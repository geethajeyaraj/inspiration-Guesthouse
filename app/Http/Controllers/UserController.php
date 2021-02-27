<?php

namespace App\Http\Controllers;

use App\Models\User;
use Response;
use Illuminate\Http\Request;
use DB;
use DataTables;
use Session;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Collection;
use Image;
use Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->show_data();
        } else {
            return view('index')->with($this->get_data());
        }
    }
    public function show_data()
    {
        $data = DB::table('users')->join('roles', 'roles.id', 'users.role_id')->leftJoin('master_countries', 'master_countries.id', 'users.country')->leftJoin('master_states', 'master_states.id', 'users.state')->leftJoin('master_cities', 'master_cities.id', 'users.city')->select('users.*', 'roles.name as role_name','master_countries.country_name','master_states.state_name','master_cities.city_name');

        if(session('role')!=1)
        {
        $data->where('role_id',3);
        }

        

        $datatables = Datatables::of($data);
        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
          <i class="la la-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("users.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit Details</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
        </div>
    </span>';
        });
        return $datatables->make(true);
    }
    public function get_data()
    {
        $data['title'] = "Users";
        $data['data_url'] = route('users.index');
        $fields[] = array('id' => "id", 'name' => "users.id", 'display_name' => "ID");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "users.status", 'display_name' => "Status", 'condition' => $condition);
        $fields[] = array('id' => "action", 'name' => "action", 'display_name' => "Action", 'orderable' => "false", 'searchable' => "false");

        $fields[] = array('id' => "user_name", 'name' => "users.user_name", 'display_name' => "User Name");
        $fields[] = array('id' => "email", 'name' => "users.email", 'display_name' => "Email");
        $fields[] = array('id' => "display_name", 'name' => "users.display_name", 'display_name' => "Display Name");
        $fields[] = array('id' => "mobile_no", 'name' => "users.mobile_no", 'display_name' => "Mobile no");
        $fields[] = array('id' => "role_name", 'name' => "roles.name", 'display_name' => "Role Name");

     
        $fields[] = array('id' => "gender", 'name' => "gender", 'display_name' => "Gender");
        $fields[] = array('id' => "nationality", 'name' => "nationality", 'display_name' => "Nationality");

        $fields[] = array('id' => "address_line1", 'name' => "address_line1", 'display_name' => "Address Line 1");
        $fields[] = array('id' => "address_line2", 'name' => "address_line2", 'display_name' => "Address Line 2");

        $fields[] = array('id' => "city_name", 'name' => "master_cities.city_name", 'display_name' => "City");
        $fields[] = array('id' => "state_name", 'name' => "master_states.state_name", 'display_name' => "State");
       
        $fields[] = array('id' => "country_name", 'name' => "master_countries.country_name", 'display_name' => "Country");
    

        $fields[] = array('id' => "id_proof", 'name' => "id_proof", 'display_name' => "Id Proof");
        $fields[] = array('id' => "id_proof_no", 'name' => "id_proof_no", 'display_name' => "Id Proof No");



        
        $data['fields'] = $fields;
        $data['permission'] = 'user';
        $data['responsive'] = 'true';
        $data['create_url'] = route('users.create');
        $data['is_ajax_create'] = 'yes';
        $data['post_type'] = 'get';
        $data['delete_url'] = route('users.destroy', "delete_id");
        return $data;
    }

    
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create', 'url' => route('users.store'), 'form_name' => 'user', 'display_name' => 'User']);
        return view($view)->with(['collection' => $collection, 'rows' => $rows, 'modal_class' => 'modal-lg']);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users|min:2|max:20',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'display_name' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        $current = Carbon::now();
        $user = new User;
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->mobile_no = $request->mobile_no;
        $user->status = $request->status;
        $user->role_id = $request->role_id;
        if ($request->password <> "") {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $file = $request->file('image_location');
        $destinationPath = 'user_photos';
        if (isset($file)) {
            $actual_name = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $original_name = $actual_name;
            $extension = $file->getClientOriginalExtension();
            $i = 1;
            while (file_exists(storage_path('app/user_photos/' . $actual_name . "." . $extension))) {
                $actual_name = (string) $original_name . $i;
                $i++;
            }
            $file_name = $actual_name . "." . $extension;
            $user->image_location = $request->file('image_location')->storeAs('user_photos', $file_name);
            $user->save();
        }
        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "User Data successfully added.",
            );
        }
        return redirect()->route('users.index')->with('message', 'User data successfully inserted...');
        //return redirect()->route('users.index');
    }
    public function show($id)
    {
        //
    }
    public function edit($id, Request $request)
    {
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $user = User::find($id);
        $user->password = "";
        //$rows = collect($this->get_rows());
        $rows = collect($this->get_rows($user, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes', 'url' => 'users', 'form_name' => 'user', 'display_name' => 'User Details']);
        return view($view)->with(['model_name' => $user, 'collection' => $collection, 'rows' => $rows, 'modal_class' => 'modal-lg']);
    }
    public function get_rows($model, $form_type)
    {
        $roles = DB::table('roles')->pluck('name', 'id');
        $i = 0;
        $rows[$i][] = array('field_name' => 'user_name', 'label_name' => 'User Name', 'field_type' => 'text', 'placeholder' => 'Enter User Name', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'email', 'label_name' => 'Email', 'field_type' => 'text', 'placeholder' => 'Enter Email Id', 'class_name' => 'email required');
        $rows[$i][] = array('field_name' => 'mobile_no', 'label_name' => 'Mobile no', 'field_type' => 'text', 'placeholder' => 'Enter Mobile no', 'class_name' => 'required');
        $i++;
        $rows[$i][] = array('field_name' => 'display_name', 'label_name' => 'Display Name', 'field_type' => 'text', 'placeholder' => 'Enter First Name', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'role_id', 'label_name' => 'Role', 'field_type' => 'select', 'placeholder' => 'Select Role', 'values_data' => $roles, 'class_name' => 'select2 required', 'id' => 'role_id');
        $status = array("0" => 'Inactive', "1" => "Active");
        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status', 'values_data' => $status, 'class_name' => 'select2 required', 'id' => 'status');

        
        $i++;

        $rows[$i][] = array('field_name' => 'password', 'label_name' => 'Password', 'field_type' => 'password', 'placeholder' => 'Enter Password', 'class_name' => '', 'id' => 'password');
        $rows[$i][] = array('field_name' => 'image_location', 'label_name' => 'User Image', 'field_type' => 'image', 'placeholder' => 'Select Image');
        $rows[$i][] = array('field_type' => 'empty');
        return $rows;
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|min:3|max:20',
            'email' => 'email|required',
            'display_name' => 'required',
            'role_id' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        $current = Carbon::now();
        $user = User::find($id);
        $user->user_name = $request->user_name;
        $user->email = $request->email;
        $user->display_name = $request->display_name;
        $user->mobile_no = $request->mobile_no;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        if ($request->password <> "") {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        $file = $request->file('image_location');
        $destinationPath = 'user_photos';
        if (isset($file)) {
            $actual_name = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $original_name = $actual_name;
            $extension = $file->getClientOriginalExtension();
            $i = 1;
            while (file_exists(storage_path('app/user_photos/' . $actual_name . "." . $extension))) {
                $actual_name = (string) $original_name . $i;
                $i++;
            }
            $file_name = $actual_name . "." . $extension;
            $user->image_location = $request->file('image_location')->storeAs('user_photos', $file_name);
            $user->save();
        }
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "User successfully updated...");
        }
        return redirect()->route('users.index')->with('message', 'User successfully updated...');
    }
    public function destroy($id, Request $request)
    {
        DB::table('users')->where('id', $id)->delete();
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "User successfully deleted.");
        }
        return redirect()->route('users.index')->with('message', 'User successfully deleted.');
    }
    public function list_users($id, Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return Response::json([]);
        }

        $experts = User::where(function ($q) use ($term) {
            $q->where('user_name', 'like', '%' . $term . '%')
                ->orWhere('mobile_no', 'like', '%' . $term . '%');
        })->select('users.id', 'users.user_name', 'users.mobile_no');

        if ($id != 0) {
            $experts = $experts->where('role_id', $id);
        }


        
        $experts = $experts->limit(20)->get();
        $formatted_experts = [];
        foreach ($experts as $expert) {
            $formatted_experts[] = ['id' => $expert->id, 'text' =>  $expert->user_name . '-' . $expert->mobile_no];
        }
        return response()->json($formatted_experts);


    }
    public function photo($filename, Request $request)
    {
        if (file_exists(storage_path('app/user_photos/' . $filename))) {
            $filename = 'app/user_photos/' . $filename;
            $path = storage_path($filename);
            return response()->file($path);
        } else {
            return '';
        }
    }
}
