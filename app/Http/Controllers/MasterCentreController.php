<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class MasterCentreController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
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
        $data = DB::table('master_aravind_centres');
        $datatables = Datatables::of($data);

        $datatables->addColumn('action', function ($sdata) {

      
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("master_aravind_centres.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Master Aravind Centres";
        $data['data_url']=route('master_aravind_centres.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"centre_name", 'name'=>"centre_name",'display_name'=>"Centre Name");
        
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "users.status", 'display_name' => "Status", 'condition' => $condition);
      
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'role';
        $data['create_url'] = route('master_aravind_centres.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('master_aravind_centres.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('master_aravind_centres.index'),'form_name'=>'master','display_name'=>'Aravind centres']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'centre_name' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('centre_name','status');
        $child['updated_at']= $current;
        DB::table('master_aravind_centres')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Centre successfully added.",
            );
        } 
        return redirect()->route('master_aravind_centres.index')->with('message', 'Centre details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $role = DB::table('master_aravind_centres')->where('id',$id)->first();
        $rows = collect($this->get_rows($role, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'master_aravind_centres','form_name'=>'master','display_name'=>'Aravind Centres']);
        return view($view)->with(['model_name' => $role, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][] = array('field_name' => 'centre_name', 'label_name' => 'Centre Name', 'field_type' => 'text', 'placeholder' => 'Enter Centre Name', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>['1'=>'Active','0'=>'Inactive'], 'class_name' => 'select2 required');
       

        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'centre_name' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('centre_name','status');
        $child['updated_at']= $current;
        DB::table('master_aravind_centres')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Centre details successfully updated...");
        } 

        return redirect(route('master_aravind_centres.index'))->with('message','Centre details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('master_aravind_centres')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Centre Details successfully deleted.");
        }


        return redirect(route('master_aravind_centres.index'))->with('message','Centre details successfully Deleted...!');
    }


}
