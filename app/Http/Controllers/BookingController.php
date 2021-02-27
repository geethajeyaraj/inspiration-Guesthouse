<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Helpers;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index($id, Request $request)
    {
        if ($request->ajax()) {
            return $this->show_data($id);
        } else {
            return view('index')->with($this->get_data($id));
        }
    }


    public function show_data($id)
    {
        $data = DB::table('bookings')->where('reservation_id', $id)->leftJoin('master_countries', 'master_countries.id', 'bookings.country')->leftJoin('master_states', 'master_states.id', 'bookings.state')->leftJoin('master_cities', 'master_cities.id', 'bookings.city')->select('bookings.*', 'master_countries.country_name', 'master_states.state_name', 'master_cities.city_name');
        $datatables = Datatables::of($data);
        $datatables->editColumn('id', function ($a) {
            return '#B'.$a->id;
        });
        $datatables->editColumn('id_proof_location', function ($sdata) {
            if ($sdata->id_proof_location!="") {
                return '<a target="_blank" href="'.Storage::url($sdata->id_proof_location).'" class="btn btn-sm btn-success btn-icon btn-icon-md">
            Proof</a>';
            } else {
                return "-";
            }
        });
        $datatables->editColumn('formc_proof_location', function ($sdata) {
            if ($sdata->formc_proof_location!="") {
                return '<a target="_blank" href="'.Storage::url($sdata->formc_proof_location).'" class="btn btn-sm btn-success btn-icon btn-icon-md">
            Form C</a>';
            } else {
                return "-";
            }
        });
        $datatables->rawColumns(['action','id_proof_location','formc_proof_location']);
        $datatables->addColumn('action', function ($sdata) {
            $action='<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >';
            $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("bookings.edit", [$sdata->reservation_id, $sdata->id]) . '"><i class="la la-edit"></i> Edit</a>';
            $action=$action.'<a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>';
            $action=$action.'</div></span>';
            return $action;
        });
        return $datatables->make(true);
    }


    public function get_data($id)
    {
        $data['title']='Reservation <a class="ajax-popup" href="' . route("reservation_control.show", $id) . '"></i>   #'.$id.'</a>';
        $data['data_url']=route('bookings.index', $id);
        $fields[]=array('id'=>"id", 'name'=>"bookings.id",'display_name'=>"ID");
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");
        $fields[] = array('id' => "title", 'name' => "title", 'display_name' => "Title");
        $fields[] = array('id' => "display_name", 'name' => "display_name", 'display_name' => "Name");
        $fields[] = array('id' => "email", 'name' => "email", 'display_name' => "Email");
        $fields[] = array('id' => "mobile_no", 'name' => "mobile_no", 'display_name' => "Mobile no");
        $fields[] = array('id' => "guest_or_trainee", 'name' => "guest_or_trainee", 'display_name' => "Guest type");
        $fields[] = array('id' => "gender", 'name' => "gender", 'display_name' => "Gender");
        $fields[] = array('id' => "nationality", 'name' => "nationality", 'display_name' => "Nationality");
        $fields[] = array('id' => "address_line1", 'name' => "address_line1", 'display_name' => "Address Line 1");
        $fields[] = array('id' => "address_line2", 'name' => "address_line2", 'display_name' => "Address Line 2");
        $fields[] = array('id' => "city_name", 'name' => "master_cities.city_name", 'display_name' => "City");
        $fields[] = array('id' => "state_name", 'name' => "master_states.state_name", 'display_name' => "State");
        $fields[] = array('id' => "country_name", 'name' => "master_countries.country_name", 'display_name' => "Country");
        $fields[] = array('id' => "id_proof", 'name' => "id_proof", 'display_name' => "Id Proof");
        $fields[] = array('id' => "id_proof_no", 'name' => "id_proof_no", 'display_name' => "Id Proof No");
        $fields[] = array('id' => "id_proof_location", 'name' => "id_proof_location", 'display_name' => "Id Proof");
        $fields[] = array('id' => "formc_proof_location", 'name' => "formc_proof_location", 'display_name' => "Form-C Proof");
        $data['responsive'] = true;
        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('bookings.create', $id);
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('bookings.destroy', [$id,"delete_id"]);
        $data['post_type'] = 'get';
        return $data;
    }


    public function create($id, Request $request)
    {
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $rows = collect($this->get_rows($id, 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('bookings.index', $id),'form_name'=>'master','display_name'=>'Booking Details']);
        return view($view)->with(['collection' => $collection, 'rows' => $rows , 'modal_class' => 'modal-lg','custom_scripts'=>'scripts.getstateandcities']);
    }


    public function store($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'display_name' => 'required',
            'id_proof_location' => 'required',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        $reservation= DB::TABLE('reservations')->where('id', $id)->first();
        $current = Carbon::now();
        $data = $request->only('title', 'email', 'mobile_no', 'display_name', 'gender', 'land_line', 'nationality', 'address_line1', 'address_line2', 'country', 'state', 'city', 'pincode', 'guest_or_trainee', 'id_proof', 'id_proof_no', 'payment_mode_id', 'room_type_id');
        $data['id_proof_location'] = $request->file('id_proof_location')->store('id_proof', 'public');
        $file=$request->file('formc_proof_location');
        if (isset($file)) {
            $data['formc_proof_location'] = $request->file('formc_proof_location')->store('id_proof', 'public');
        }
        $data['checkin_date']= $reservation->checkin_date;
        $data['checkout_date']=$reservation->checkout_date;
        $data['reservation_id']=$id;
        $data['room_rent']=0;
        $data['room_tax']=0;
        $data['room_discount']=0;
        $data['updated_at']= $current;
        $insertId=DB::table('bookings')->insertGetId($data);
        Helpers::update_total_amount($insertId);
        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Booking successfully added...",
            );
        }
        return redirect()->route('bookings.index', $id)->with('message', 'Booking successfully inserted...');
    }


    public function show($id)
    {
        //
    }


    public function edit($reservation_id, $id, Request $request)
    {
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $model_name = DB::table('bookings')->where('id', $id)->first();
        

        $model_name->checkin_date_old  = $model_name->checkin_date;
        $model_name->checkout_date_old  =$model_name->checkout_date;



        
        $model_name->checkin_date  = Carbon::parse($model_name->checkin_date)->format('d/m/Y h:i A');
        $model_name->checkout_date  = Carbon::parse($model_name->checkout_date)->format('d/m/Y h:i A');


        $mode = 'Edit';
        $title = 'Booking #'. $id;
        if (isset($request->status_update)) {
            $title =  $request->status_update . ' Status #' . $id;
            $mode = $request->status_update;
        }
        if (isset($request->mode)) {
            $mode=$request->mode;
        }

        //  return "room_no not in(select room_no from bookings where id!=".$model_name->id." and room_no is not null and (checkin_date between '".$model_name->checkin_date ."' and '".$model_name->checkout_date ."'  or  checkout_date between '".$model_name->checkin_date ."' and '".$model_name->checkout_date ."'))";



        $rows = collect($this->get_rows($model_name, $mode));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','update_url'=>route('bookings.update', [$reservation_id, $id]),'delete_url'=>route('bookings.destroy', [$reservation_id, $id]),'form_name'=>'master','display_name'=>$title]);
        return view($view)->with(['model_name' => $model_name, 'modal_class' =>  $mode!="Reservation" ? 'modal-lg':'', 'collection' => $collection, 'rows' => $rows ,'custom_scripts'=>'scripts.getstateandcities']);
    }


    public function get_rows($model_name, $form_type)
    {
        $id_proofs= DB::table("master_id_proofs")->pluck('id_proof_name', 'id');
        $payments = db::table('master_payment_details')->pluck('payment_details', 'id');
        $room_types = db::table('master_room_types as t')->where('status', 1)->pluck('room_type', 'id');
        if ($form_type == "Reservation") {
            $i = 0;
            $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Reservation Status', 'values_data' => ['0' => 'Waiting', '1' => 'Confirmed', '5' => 'Cancelled'], 'class_name' => 'select2 required');
        } elseif ($form_type == "allcheckin") {
            //  $bookings = DB::table('bookings')->where('id',$model_name->id)->first();
            //  $room_details = db::table('master_room_details')->where('room_type_id', $model_name->room_type_id)->pluck('room_no', 'room_no');

            $room_details = db::table('master_room_details')->where('room_type_id', $model_name->room_type_id)->whereRaw("room_no not in(select room_no from bookings where id!=".$model_name->id." and room_no is not null and (checkin_date between '".$model_name->checkin_date_old ."' and '".$model_name->checkout_date_old ."'  or  checkout_date between '".$model_name->checkin_date_old ."' and '".$model_name->checkout_date_old ."'))")->pluck('room_no', 'room_no');


            $i = 0;
            $rows[$i][] = array('field_name' => 'checkin_date', 'label_name' => 'Checkin Date', 'field_type' => 'text', 'placeholder' => 'Select CheckIn Date', 'class_name' => 'required date-time-picker');
            $rows[$i][] = array('field_name' => 'checkout_date', 'label_name' => 'Checkout Date', 'field_type' => 'text', 'placeholder' => 'Select Checkout Date','class_name' => 'required date-time-picker');
            $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Checkin Status', 'values_data' => ['1'=>'Waiting for Checkin','2' => 'Checkin', '3' => 'Checkout'], 'class_name' => 'select2 required');
            $i++;
            $rows[$i][] = array('field_name' => 'payment_mode_id', 'label_name' => 'Payment Mode', 'field_type' => 'select', 'placeholder' => 'Select Payment Mode', 'values_data'=>$payments, 'class_name' => 'select2 required');
            $rows[$i][] = array('field_name' => 'room_type_id', 'label_name' => 'Room type', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>$room_types, 'class_name' => 'select2 required');
            $rows[$i][] = array('field_name' => 'room_no', 'label_name' => 'Room No', 'field_type' => 'select', 'placeholder' => 'Select Room no','values_data'=> $room_details, 'class_name' => 'select2');
        } elseif ($form_type == "checkin") {
            //  $bookings = DB::table('bookings')->where('id',$model_name->id)->first();
            //    $room_details = db::table('master_room_details')->where('room_type_id', $model_name->room_type_id)->pluck('room_no', 'room_no');
            $i = 0;
            $rows[$i][] = array('field_name' => 'checkin_date', 'label_name' => 'Checkin Date', 'field_type' => 'text', 'placeholder' => 'Select CheckIn Date', 'class_name' => 'required date-time-picker');
            $rows[$i][] = array('field_name' => 'checkout_date', 'label_name' => 'Checkout Date', 'field_type' => 'text', 'placeholder' => 'Select Checkout Date','class_name' => 'required date-time-picker');
            //   $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Checkin Status', 'values_data' => ['1'=>'Waiting for Checkin','2' => 'Checkin', '3' => 'Checkout'], 'class_name' => 'select2 required');
            $i++;
            $rows[$i][] = array('field_name' => 'payment_mode_id', 'label_name' => 'Payment Mode', 'field_type' => 'select', 'placeholder' => 'Select Payment Mode', 'values_data'=>$payments, 'class_name' => 'select2 required');
            $rows[$i][] = array('field_name' => 'room_type_id', 'label_name' => 'Room type', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>$room_types, 'class_name' => 'select2 required');
        //    $rows[$i][] = array('field_name' => 'room_no', 'label_name' => 'Room No', 'field_type' => 'select', 'placeholder' => 'Select Room no','values_data'=> $room_details, 'class_name' => 'select2');
        } elseif ($form_type == "checkinstatus") {
            //     $room_details = db::table('master_room_details')->where('room_type_id', $model_name->room_type_id)->pluck('room_no', 'room_no');


            $room_details = db::table('master_room_details')->where('room_type_id', $model_name->room_type_id)->whereRaw("room_no not in(select room_no from bookings where id!=".$model_name->id." and room_no is not null and (checkin_date between '".$model_name->checkin_date_old ."' and '".$model_name->checkout_date_old ."'  or  checkout_date between '".$model_name->checkin_date_old ."' and '".$model_name->checkout_date_old ."'))")->pluck('room_no', 'room_no');

            
            $i = 0;
            
         //   if( $model_name->status==1)
            $status=['1'=>'Waiting for Checkin','2' => 'Checkin', '3' => 'Checkout'];
         //   else
         //   $status=['2' => 'Checkin', '3' => 'Checkout'];
           
            $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Checkin Status', 'values_data' => $status, 'class_name' => 'select2 required');



            $rows[$i][] = array('field_name' => 'room_no', 'label_name' => 'Room No', 'field_type' => 'select', 'placeholder' => 'Select Room no','values_data'=> $room_details, 'class_name' => 'select2');
        } else {
            $countries= DB::table("master_countries")->pluck('country_name', 'id');
            $states=array();
            if (isset($model_name->state)) {
                $states=DB::table("master_states")->where('id', $model_name->state)->pluck('state_name', 'id');
            }
            $cities=array();
            if (isset($model_name->city)) {
                $cities=DB::table("master_cities")->where('id', $model_name->city)->pluck('city_name', 'id');
            }
            $i=0;
            if ($form_type == "editdate") {
                $rows[$i][] = array('field_name' => 'checkin_date', 'label_name' => 'Checkin Date', 'field_type' => 'text', 'placeholder' => 'Select CheckIn Date', 'class_name' => 'required date-time-picker');
                $rows[$i][] = array('field_name' => 'checkout_date', 'label_name' => 'Checkout Date', 'field_type' => 'text', 'placeholder' => 'Select Checkout Date','class_name' => 'required date-time-picker');
                $rows[$i][] = array('field_type' => 'empty');
                $i++;
            }
            $rows[$i][] = array('field_name' => 'title', 'label_name' => 'Title', 'field_type' => 'select', 'placeholder' => 'Select Title', 'values_data' => ['Mr'=>'Mr','Ms'=>'Ms','Dr'=>'Dr'], 'class_name' => 'select2 required', 'id' => 'status');
            $rows[$i][] = array('field_name' => 'display_name', 'label_name' => 'Display Name', 'field_type' => 'text', 'placeholder' => 'Enter Name', 'class_name' => 'required');
            $rows[$i][] = array('field_name' => 'email', 'label_name' => 'Email', 'field_type' => 'text', 'placeholder' => 'Enter Email Id', 'class_name' => 'email required');
            $i++;
            $rows[$i][] = array('field_name' => 'mobile_no', 'label_name' => 'Mobile no', 'field_type' => 'text', 'placeholder' => 'Enter Mobile no', 'class_name' => 'required');
            $rows[$i][] = array('field_name' => 'land_line', 'label_name' => 'Land line', 'field_type' => 'text', 'placeholder' => 'Enter land_line', 'class_name' => '');
            $rows[$i][] = array('field_name' => 'gender', 'label_name' => 'Gender', 'field_type' => 'select', 'placeholder' => 'Select gender', 'values_data' =>  ['Male'=>'Male','Female'=>'Female','Transgender'=>'Transgender'], 'class_name' => 'select2 required', 'id' => 'gender');
            $i++;
            $rows[$i][] = array('field_name' => 'nationality', 'label_name' => 'Nationality', 'field_type' => 'select', 'placeholder' => 'Select Nationality', 'values_data' =>  ['Indian'=>'Indian','Others'=>'Others'] , 'class_name' => 'select2 required', 'id' => 'nationality');
            $rows[$i][] = array('field_name' => 'address_line1', 'label_name' => 'Address line1', 'field_type' => 'text', 'placeholder' => 'Enter address_line1', 'class_name' => 'required');
            $rows[$i][] = array('field_name' => 'address_line2', 'label_name' => 'Address line2', 'field_type' => 'text', 'placeholder' => 'Enter address_line2', 'class_name' => '');
            $i++;
            $rows[$i][] = array('field_name' => 'country', 'label_name' => 'country', 'field_type' => 'select', 'placeholder' => 'Select country', 'values_data' =>  $countries  , 'class_name' => 'select2 required', 'id' => 'country');
            $rows[$i][] = array('field_name' => 'state', 'label_name' => 'state', 'field_type' => 'select', 'placeholder' => 'Select state', 'values_data' =>  $states  , 'class_name' => 'select2 required', 'id' => 'country');
            $rows[$i][] = array('field_name' => 'city', 'label_name' => 'city', 'field_type' => 'select', 'placeholder' => 'Select city', 'values_data' =>  $cities  , 'class_name' => 'select2 required', 'id' => 'city');
            $i++;
            $rows[$i][] = array('field_name' => 'pincode', 'label_name' => 'pincode', 'field_type' => 'text', 'placeholder' => 'pincode','class_name' => 'required', 'id' => 'pincode');
            $rows[$i][] = array('field_name' => 'id_proof', 'label_name' => 'Id Proof', 'field_type' => 'select', 'placeholder' => 'Select Id Proof', 'values_data' =>  $id_proofs  , 'class_name' => 'select2 required', 'id' => 'id_proof');
            $rows[$i][] = array('field_name' => 'id_proof_no', 'label_name' => 'Id Proof No', 'field_type' => 'text', 'placeholder' => 'Enter Id Proof No', 'class_name' => 'required');
            $i++;
            $rows[$i][] = array('field_name' => 'guest_or_trainee', 'label_name' => 'Guest Type', 'field_type' => 'select', 'placeholder' => 'Select Guest type', 'values_data' =>  ['Guest'=>'Guest','Trainee'=>'Trainee'] , 'class_name' => 'select2 required', 'id' => 'guest_or_trainee');
            $rows[$i][] = array('field_name' => 'room_type_id', 'label_name' => 'Room type', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>$room_types, 'class_name' => 'select2 required');
            $rows[$i][] = array('field_name' => 'payment_mode_id', 'label_name' => 'Payment Mode', 'field_type' => 'select', 'placeholder' => 'Select Payment Mode', 'values_data'=>$payments, 'class_name' => 'select2 required');
            $i++;
            $rows[$i][] = array('field_name' => 'meal_needed', 'label_name' => 'Meal Needed', 'field_type' => 'select', 'placeholder' => 'Select Meal Needed', 'values_data'=>[0=>'No',1=>"Yes"], 'class_name' => 'select2 required');
            $rows[$i][] = array('field_name' => 'id_proof_location', 'label_name' => 'id proof', 'field_type' => 'image', 'placeholder' => 'Select Id Proof');
            $rows[$i][] = array('field_name' => 'formc_proof_location', 'label_name' => 'Form C Proof Location', 'field_type' => 'image', 'placeholder' => 'Select formc_proof');
        }
        return $rows;
    }


    public function update(Request $request, $reservation_id, $id)
    {
        /*   if (!isset($request->room_no)) {
               $validator = Validator::make($request->all(), [
               'email' => 'email|required',
               'display_name' => 'required',
           ]);
               if ($validator->fails()) {
                   if ($request->ajax()) {
                       return array('status' => false, 'notification' => $validator->errors()->all());
                   } else {
                       return back()->withErrors($validator)->withInput();
                   }
               }
           }
        */

        $current = Carbon::now();
        $data = $request->only('title', 'email', 'mobile_no', 'display_name', 'gender', 'land_line', 'nationality', 'address_line1', 'address_line2', 'country', 'state', 'city', 'pincode', 'guest_or_trainee', 'id_proof', 'id_proof_no', 'status', 'payment_mode_id', 'room_type_id', 'room_no', 'meal_needed');
        if (isset($request->checkin_date)) {
            $data['checkin_date'] =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
            $data['checkout_date'] = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
            $checkin_date =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
            $checkout_date = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
            if ($checkin_date>$checkout_date) {
                return array(
                'status' => false,
                'notification' => "Please check the Checkin Date and Checkout Date!",
            );
            }
        }
        $data['updated_at']= $current;
        DB::table('bookings')->where('id', $id)->update($data);
        Helpers::update_total_amount($id);
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Booking details successfully updated...");
        }
        return redirect(route('bookings.index', $reservation_id))->with('message', 'Booking details successfully updated...!');
    }


    public function destroy(Request $request, $reservation_id, $id)
    {
        DB::table('bookings')->where('id', $id)->delete();
        Helpers::update_total_amount($id);
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Booking Details successfully deleted.");
        }
        return redirect(route('bookings.index', $reservation_id))->with('message', 'Booking details successfully Deleted...!');
    }
}
