<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class MasterRoomDetailsController extends Controller
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
        $data = DB::table('master_room_details as p')->join('master_room_types as t','p.room_type_id','t.id')->select('p.*','t.room_type');
        $datatables = Datatables::of($data);



        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("master_room_details.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Master Room Details";
        $data['data_url']=route('master_room_details.index');

        $fields[]=array('id'=>"id", 'name'=>"p.id",'display_name'=>"ID");

        $fields[]=array('id'=>"room_type", 'name'=>"t.room_type",'display_name'=>"Room type");

        $fields[]=array('id'=>"room_no", 'name'=>"p.room_no",'display_name'=>"Room Number");
    


        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "p.status", 'display_name' => "Status", 'condition' => $condition);
      
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('master_room_details.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('master_room_details.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('master_room_details.index'),'form_name'=>'master','display_name'=>'Room Details']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           
            'room_type_id' => 'required',
            'room_no' => 'required',
           
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('room_type_id','room_no','status');
        $child['updated_at']= $current;


        DB::table('master_room_details')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Room successfully added.",
            );
        } 
        return redirect()->route('master_room_details.index')->with('message', 'Room details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $data = DB::table('master_room_details')->where('id',$id)->first();

       

        $rows = collect($this->get_rows($data, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'master_room_details','form_name'=>'master','display_name'=>'Room Details']);
        return view($view)->with(['model_name' => $data, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {

        $room_types=DB::table('master_room_types')->pluck('room_type','id');

        $i=0;

        $rows[$i][] = array('field_name' => 'room_type_id', 'label_name' => 'Room Type', 'field_type' => 'select', 'placeholder' => 'Select Room Type', 'values_data'=> $room_types , 'class_name' => 'select2 required');

        $rows[$i][] = array('field_name' => 'room_no', 'label_name' => 'Room No', 'field_type' => 'text', 'placeholder' => 'Enter Room No', 'class_name' => 'required');
        
        $i++;
        
  
        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>['1'=>'Active','0'=>'Inactive'], 'class_name' => 'select2 required');
       
        $rows[$i][] = array('field_type' => 'empty');
     


        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
           
            'room_type_id' => 'required',
            'room_no' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('room_type_id','room_no','status');
        $child['updated_at']= $current;

      
        DB::table('master_room_details')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Room details successfully updated...");
        } 

        return redirect(route('master_room_details.index'))->with('message','Room details successfully updated...!');


    }

     public function destroy(Request $request,$id)
    {
        DB::table('master_room_details')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Room Details successfully deleted.");
        }


        return redirect(route('master_room_details.index'))->with('message','Room details successfully Deleted...!');
    }



}
