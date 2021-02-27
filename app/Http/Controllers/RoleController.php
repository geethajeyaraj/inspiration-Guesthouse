<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class RoleController extends Controller
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
        $students = DB::table('roles');
        $datatables = Datatables::of($students);

        $datatables->addColumn('action', function ($sdata) {

        if($sdata->id>1){
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("roles.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        }else{
            return "";
        }
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="User Roles";
        $data['data_url']=route('roles.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"name", 'name'=>"name",'display_name'=>"Role Name");
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'role';
        $data['create_url'] = route('roles.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('roles.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=>'admin/roles','form_name'=>'role','display_name'=>'Role']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('name');
        $child['updated_at']= $current;
        DB::table('roles')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Exam successfully added.",
            );
        } 
        return redirect()->route('roles.index')->with('message', 'Role details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $role = DB::table('roles')->where('id',$id)->first();
        $rows = collect($this->get_rows($role, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'roles','form_name'=>'role','display_name'=>'Role']);
        return view($view)->with(['model_name' => $role, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][0] = array('field_name' => 'name', 'label_name' => 'Role Name', 'field_type' => 'text', 'placeholder' => 'Enter Role Name', 'class_name' => 'required');
       
        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('name');
        $child['updated_at']= $current;
        DB::table('roles')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Role details successfully updated...");
        } 

        return redirect(route('roles.index'))->with('message','Role details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('roles')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Role Details successfully deleted.");
        }


        return redirect(route('roles.index'))->with('message','Role details successfully Deleted...!');
    }
}
