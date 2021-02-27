<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;
use App\Http\Helpers;


class ReservationRoomController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id,Request $request)
    {

        if ($request->ajax()) {
            return $this->show_data($id);
        } else {
            return view('index')->with($this->get_data($id));
        }

        
    }

    public function show_data($id)
    {
        $data = DB::table('reservation_rooms')->join('master_room_types','master_room_types.id','reservation_rooms.room_type_id')->select('reservation_rooms.*','master_room_types.room_type')->where('reservation_id',$id);
        $datatables = Datatables::of($data);

        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("reservation_rooms.edit", [$sdata->reservation_id, $sdata->id]) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data($id)
    {

        


        $data['title']='Reservation Rooms <a class="ajax-popup" href="' . route("reservation_control.show", $id) . '"></i>   #'.$id.'</a>';

        $data['data_url']=route('reservation_rooms.index',$id);

        $fields[]=array('id'=>"id", 'name'=>"reservation_rooms.id",'display_name'=>"ID");

        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");
        $fields[]=array('id'=>"room_type", 'name'=>"master_room_types",'display_name'=>"Room Type");
      //  $fields[]=array('id'=>"no_of_rooms", 'name'=>"no_of_rooms",'display_name'=>"No of rooms");
        $fields[]=array('id'=>"no_of_extra_beds", 'name'=>"no_of_extra_beds",'display_name'=>"No of Extra Beds");
       

        $fields[]=array('id'=>"room_rent", 'name'=>"room_rent",'display_name'=>"Room rent");
        $fields[]=array('id'=>"extra_bed_amount", 'name'=>"extra_bed_amount",'display_name'=>"Extra Bed amount");
        $fields[]=array('id'=>"tax_percentage", 'name'=>"tax_percentage",'display_name'=>"Tax Percentage");
        $fields[]=array('id'=>"discount", 'name'=>"discount",'display_name'=>"Discount");
        

        $fields[]=array('id'=>"room_no", 'name'=>"room_no",'display_name'=>"Room No");
 
 


        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('reservation_rooms.create',$id);
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('reservation_rooms.destroy', [$id,"delete_id"]);
        $data['post_type'] = 'get';
        return $data;

    }


    public function create($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows($id, 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('reservation_rooms.index',$id),'form_name'=>'master','display_name'=>'Reservation Room']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_type_id' => 'required',
         //   'no_of_rooms' => 'required',
            'no_of_extra_beds' => 'required',
            'room_rent' => 'required',
            'extra_bed_amount' => 'required',
            'tax_percentage' => 'required',

        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $data = $request->only('room_type_id','no_of_extra_beds','room_rent','extra_bed_amount','tax_percentage','discount');

        $data['reservation_id']=$id;
        $data['no_of_rooms']=1;


        $data['updated_at']= $current;
        DB::table('reservation_rooms')->insert($data);

        Helpers::update_total_amount($id);


        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Reservation room successfully added.",
            );
        } 
        return redirect()->route('master_id_proof.index')->with('message', 'Reservation room successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($reservation_id, $id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $model_name = DB::table('reservation_rooms')->where('id',$id)->first();
     

        $rows = collect($this->get_rows($model_name, 'Edit'));
        
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','update_url'=>route('reservation_rooms.update',[$reservation_id, $id]),'delete_url'=>route('reservation_rooms.destroy',[$reservation_id, $id]),'form_name'=>'master','display_name'=>'Reservation Rooms #'.$reservation_id]);
        return view($view)->with(['model_name' => $model_name, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($model_name, $form_type)
    {

        $room_details =[];

        if($form_type=="Edit")
        {
            $reservations = DB::table('reservations')->where('id',$model_name->reservation_id)->first();
     
            $room_details = db::table('master_room_details')->where('room_type_id', $model_name->room_type_id)->whereRaw("room_no not in(select room_no from reservation_rooms as rr join reservations as r on r.id=rr.reservation_id and rr.id!=".$model_name->id." and rr.room_no is not null and (r.checkin_date between '".$reservations->checkin_date ."' and '".$reservations->checkout_date ."'  or  r.checkout_date between '".$reservations->checkin_date ."' and '".$reservations->checkout_date ."'))")->pluck('room_no','room_no');


        }

        $room_types = db::table('master_room_types as t')->where('status', 1)->pluck('room_type','id');

        $i=0;
 
        $rows[$i][] = array('field_name' => 'room_type_id', 'label_name' => 'Room type', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>$room_types, 'class_name' => 'select2 required');

      //  $rows[$i][] = array('field_name' => 'no_of_rooms', 'label_name' => 'No of Rooms', 'field_type' => 'text', 'placeholder' => 'Enter Name', 'class_name' => 'number required');

      $rows[$i][] = array('field_name' => 'no_of_extra_beds', 'label_name' => 'No of Extra Beds', 'field_type' => 'text', 'placeholder' => 'Enter No of Extra beds', 'class_name' => 'number required');


        $i++;
        
        $rows[$i][] = array('field_name' => 'room_rent', 'label_name' => 'Room Rent', 'field_type' => 'text', 'placeholder' => 'Room Rent', 'class_name' => 'number required');

        $rows[$i][] = array('field_name' => 'extra_bed_amount', 'label_name' => 'Extra bed amount', 'field_type' => 'text', 'placeholder' => 'Extra bed amount', 'class_name' => 'number required');


        $i++;
      
        $rows[$i][] = array('field_name' => 'tax_percentage', 'label_name' => 'Tax Percentage', 'field_type' => 'text', 'placeholder' => 'Tax Percentage', 'class_name' => 'number required');

        $rows[$i][] = array('field_name' => 'discount', 'label_name' => 'Discount', 'field_type' => 'text', 'placeholder' => 'Discount', 'class_name' => 'number required');

        $i++;

     
        if ($form_type=="Edit") {

            $rows[$i][] = array('field_name' => 'room_no', 'label_name' => 'Room No', 'field_type' => 'select', 'placeholder' => 'Select Room No','values_data'=>$room_details, 'class_name' => 'select2');

            $rows[$i][] = array('field_type' => 'empty');

        }


        return $rows;
    }


    
    public function update(Request $request,$reservation_id, $id)
    {
        $validator = Validator::make($request->all(), [
            
            'room_type_id' => 'required',
           // 'no_of_rooms' => 'required',
            'no_of_extra_beds' => 'required',
            'room_rent' => 'required',
            'extra_bed_amount' => 'required',
            'tax_percentage' => 'required',



        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $data = $request->only('room_type_id','no_of_extra_beds','room_rent','extra_bed_amount','tax_percentage','room_no','discount');


        $data['updated_at']= $current;
        DB::table('reservation_rooms')->where('id',$id)->update($data);

        Helpers::update_total_amount($reservation_id);


        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Reservation room details successfully updated...");
        } 

        return redirect(route('reservation_rooms.index',$reservation_id))->with('message','Reservation room details successfully updated...!');

    }

     public function destroy(Request $request,$reservation_id,$id)
    {
        DB::table('reservation_rooms')->where('id',$id)->delete();

        Helpers::update_total_amount($reservation_id);


        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Reservation Details successfully deleted.");
        }


        return redirect(route('reservation_rooms.index',$reservation_id))->with('message','Id Proof details successfully Deleted...!');
    }




}
