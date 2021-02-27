<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class MasterRoomTypeController extends Controller
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
        $data = DB::table('master_room_types');
        $datatables = Datatables::of($data);

        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("master_room_types.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Master Room Types";
        $data['data_url']=route('master_room_types.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"room_type", 'name'=>"room_type",'display_name'=>"Room Type");

        $fields[]=array('id'=>"max_no_of_occupants", 'name'=>"max_no_of_occupants",'display_name'=>"Max No of Occupants");
        $fields[]=array('id'=>"is_extra_bed_allowed", 'name'=>"is_extra_bed_allowed",'display_name'=>"Is extra bed allowed?");

        $fields[]=array('id'=>"color_code", 'name'=>"color_code",'display_name'=>"Color Code");

        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "users.status", 'display_name' => "Status", 'condition' => $condition);
      
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('master_room_types.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('master_room_types.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('master_room_types.index'),'form_name'=>'master','display_name'=>'Room Types']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_type' => 'required',
            'max_no_of_occupants' => 'numeric|required',
            'is_extra_bed_allowed' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('room_type','max_no_of_occupants','is_extra_bed_allowed','status','color_code');
        $child['updated_at']= $current;
        DB::table('master_room_types')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Room Type successfully added.",
            );
        } 
        return redirect()->route('master_room_types.index')->with('message', 'Room Type successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $role = DB::table('master_room_types')->where('id',$id)->first();
        $rows = collect($this->get_rows($role, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'master_room_types','form_name'=>'master','display_name'=>'Room Types']);
        return view($view)->with(['model_name' => $role, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][] = array('field_name' => 'room_type', 'label_name' => 'Room Type', 'field_type' => 'text', 'placeholder' => 'Enter Room Type', 'class_name' => 'required');


$rows[$i][] = array('field_name' => 'max_no_of_occupants', 'label_name' => 'Max no of Occupants', 'field_type' => 'text', 'placeholder' => 'Enter Max No of Occupants', 'class_name' => 'number required');

$i++;


$rows[$i][] = array('field_name' => 'is_extra_bed_allowed', 'label_name' => 'Is extra bed Allowed', 'field_type' => 'select', 'placeholder' => 'Is allowed?','values_data'=>[1=>'Yes',0=>'No'], 'class_name' => 'select2 required');

$rows[$i][] = array('field_name' => 'color_code', 'label_name' => 'Color Code', 'field_type' => 'text', 'placeholder' => 'Enter Color code', 'class_name' => '');



$i++;

        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>['1'=>'Active','0'=>'Inactive'], 'class_name' => 'select2 required');
     
        $rows[$i][] = array('field_type' => 'empty');


        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'room_type' => 'required',
            'max_no_of_occupants' => 'required',
            'is_extra_bed_allowed' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('room_type','max_no_of_occupants','is_extra_bed_allowed','status','color_code');
        $child['updated_at']= $current;
        DB::table('master_room_types')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Room type details successfully updated...");
        } 

        return redirect(route('master_room_types.index'))->with('message','Room type details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('master_room_types')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Room type Details successfully deleted.");
        }


        return redirect(route('master_room_types.index'))->with('message','Room Type details successfully Deleted...!');
    }



}
