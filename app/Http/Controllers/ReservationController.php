<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;
use App\Http\Helpers;
use App\Mail\SendStatus;
use Illuminate\Support\Facades\Mail;
class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->show_data($request);
        } else {
            return view('index')->with($this->get_data());
        }
    }


    public function show_data($request)
    {
        $data = DB::table('reservations')->join('users', 'users.id', 'reservations.user_id')->select('reservations.*', 'users.display_name', 'users.email', 'users.mobile_no', 'reservations.status as reservation_status');
        if ($request->reservation_status == "") {
            $data->where('reservations.status', '=', 0);
        } else {
            $data->where('reservations.status', '=', $request->reservation_status);
        }
        if ($request->checkin_date != "") {
            $data->whereDate('reservations.checkin_date', '=', Carbon::createFromFormat('d/m/Y', $request->checkin_date));
        }
        if ($request->checkout_date != "") {
            $data->whereDate('reservations.checkout_date', '=', Carbon::createFromFormat('d/m/Y', $request->checkout_date));
        }
        if ($request->created_at != "") {
            $data->whereDate('reservations.created_at', '=', Carbon::createFromFormat('d/m/Y', $request->created_at));
        }
        $datatables = Datatables::of($data);

        $datatables->editColumn('id', function ($a) {
            return '#R'.$a->id;
        });


        $datatables->editColumn('checkin_date', function ($a) {
            return with(new Carbon($a->checkin_date))->format('d/m/Y h:i A');
        });
        $datatables->editColumn('checkout_date', function ($a) {
            return with(new Carbon($a->checkout_date))->format('d/m/Y h:i A');
        });
        $datatables->addColumn('action', function ($sdata) {
            $action = '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-primary btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >';
           
            $action = $action . '<a  class="dropdown-item ajax-popup" href="' . route("reservation_control.show", $sdata->id) . '"><i class="la la-eye"></i> View</a>';

            if($sdata->status==0)
            $action = $action . '<a  class="dropdown-item ajax-popup" href="' . route("room_availability", $sdata->id) . '"><i class="la la-eye"></i> Availability Check</a>';
            


            $action = $action . '<a  class="dropdown-item ajax-popup" href="' . route("reservation_control.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit Reservation Status</a><a  class="dropdown-item" href="' . route("bookings.index", $sdata->id) . '"><i class="la la-edit"></i> Edit Reservation Details</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
            return $action;
        });
        return $datatables->make(true);
    }


    public function get_data()
    {
        $data['title'] = "Reservation Control";
        $data['data_url'] = route('reservation_control.index');
        $data['responsive'] = True;
        $fields[] = array('id' => "id", 'name' => "reservations.id", 'display_name' => "Reserv. ID");
        $fields[] = array('id' => "action", 'name' => "action", 'display_name' => "Action", 'orderable' => "false", 'searchable' => "false");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-warning'>Waiting</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Confirmed</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "5", 'display_name' => "<span class='badge badge-danger'>Cancelled</span>");
        $fields[] = array('id' => "reservation_status", 'name' => "reservation_status", 'display_name' => "Status", 'condition' => $condition, 'is_custom_search' => true, 'search_items' => [0 => "Waiting", 1 => "Confirmed", 5 => "Cancelled"]);
        $fields[] = array('id' => "created_at", 'name' => "reservations.created_at", 'display_name' => "Reservation Date", "is_date" => "Yes");
        $fields[] = array('id' => "display_name", 'name' => "bookings.display_name", 'display_name' => "Name");
        $fields[] = array('id' => "mobile_no", 'name' => "bookings.mobile_no", 'display_name' => "Mobile No");
        $fields[] = array('id' => "email", 'name' => "bookings.email", 'display_name' => "Email");
        $fields[] = array('id' => "checkin_date", 'name' => "checkin_date", 'display_name' => "CheckIn Date", "is_date" => "Yes");
        $fields[] = array('id' => "checkout_date", 'name' => "checkout_date", 'display_name' => "CheckOut Date", "is_date" => "Yes");
        $fields[] = array('id' => "program_purpose", 'name' => "program_purpose", 'display_name' => "Program Purpose");
        $fields[] = array('id' => "contact_person", 'name' => "reservations.contact_person", 'display_name' => "Contact Person at Aravind");
        $data['hide_columns'] = "5,6";
        $data['fields'] = $fields;
        $data['permission'] = 'role';
        $data['create_url'] = route('reservation_control.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('reservation_control.destroy', "delete_id");
        $data['post_type'] = 'get';

        $data['order_id'] = "3";
        $data['order_status'] ="Desc";


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
        $collection = collect(['form_type' => 'Create', 'url' => route('reservation_control.index'), 'form_name' => 'reservation', 'display_name' => 'Reservation']);
        return view($view)->with(['collection' => $collection, 'rows' => $rows, 'modal_class' => 'modal-lg']);
    }


    public function store(Request $request)
    {
      
      


        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'checkin_date' => 'required',
            'checkout_date' => 'required',
            'contact_person_email' => 'email',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        $checkin_date =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
        $checkout_date = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
      
        if($checkin_date>$checkout_date)
        return array(
            'status' => FALSE,
            'notification' => "Please check the Checkin Date and Checkout Date!",
        );




        $current = Carbon::now();
        $data = $request->only('user_id', 'program_purpose', 'organization', 'training_id', 'course_name', 'contact_person', 'contact_person_mobileno', 'contact_person_email', 'additional_information');
        $data['checkin_date'] =   $checkin_date ;
        $data['checkout_date'] =  $checkout_date ;
        $data['created_at'] = $current;
        DB::table('reservations')->insert($data);
        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Reservation successfully added.",
            );
        }
        return redirect()->route('reservation_control.index')->with('message', 'Reservation details successfully inserted...');
    }


    public function show($id)
    {
        $data['reservations'] = DB::table('reservations')->join('users', 'users.id', 'reservations.user_id')->select('reservations.*', 'users.display_name', 'users.mobile_no', 'users.email')->where('reservations.id', $id)->first();
        $data['reservation_guests'] = DB::table('bookings')->join('master_room_types', 'master_room_types.id', 'bookings.room_type_id')->join('master_payment_details', 'master_payment_details.id', 'bookings.payment_mode_id')->where('bookings.reservation_id', $id)->select('bookings.*', 'master_room_types.room_type', 'master_payment_details.payment_details')->get();




        return view('reservation.view')->with($data);
    }

    public function availability_check($id)
    {
        
        $data['reservations'] = DB::table('reservations')->join('users', 'users.id', 'reservations.user_id')->select('reservations.*', 'users.display_name', 'users.mobile_no', 'users.email')->where('reservations.id', $id)->first();
        $guests = DB::table('bookings')->join('master_room_types', 'master_room_types.id', 'bookings.room_type_id')->where('bookings.reservation_id', $id)->select('master_room_types.id','master_room_types.room_type', DB::RAW('count(*) as room_count'))->groupBy('master_room_types.id')->groupBy('master_room_types.room_type')->get();


        $reservation_guests=array();

        foreach( $guests as $g)
        {
           $reservation_guests[$g->id]= $g->room_count; 

        }



        $data['reservation_guests']= $reservation_guests;



        $reservations= $data['reservations'];



        $data['available_rooms'] = DB::table('master_room_details as p')->join('master_room_types as t','p.room_type_id','t.id')->leftJoin('bookings as b', function($join) use ($reservations)
        {

          $join->on('b.room_type_id','t.id');
          $join->whereRaw("(b.checkin_date between '".$reservations->checkin_date ."' and '".$reservations->checkout_date ."'  or  b.checkout_date between '".$reservations->checkin_date ."' and '".$reservations->checkout_date ."') and b.status in(1,2,3)");
         
       
        })->select('t.room_type','t.id',DB::RAW('count(*) as room_count'),DB::RAW('count(distinct b.id) as booking_count'))->groupBy('t.id')->groupBy('t.room_type')->get();


       // return  $data['available_rooms'];
        
        
        //  $data['booked_rooms'] = DB::table('master_room_types as t')->join('bookings as b','b.room_type_id','t.id')->select('t.room_type','t.id',DB::RAW('count(*) as room_count'))->groupBy('t.id')->groupBy('t.room_type')->get();
        //return $data;
        return view('reservation.view_availability')->with($data);

    }



    public function edit($id, Request $request)
    {
        if ($request->ajax()) {
            $view = "ajaxedit";
        } else {
            $view = "edit";
        };
        $data = DB::table('reservations')->where('id', $id)->first();
        $data->checkin_date  = Carbon::parse($data->checkin_date)->format('d/m/Y h:i A');
        $data->checkout_date  = Carbon::parse($data->checkout_date)->format('d/m/Y h:i A');
        //    $data->checkin_time  = Carbon::parse($data->checkin_time)->format('h:i A');
        //  $data->checkout_time  = Carbon::parse($data->checkout_time)->format('h:i A');
        $mode = 'Edit';
        $title = 'Reservations #R' . $id;
        $rows = collect($this->get_rows($data, $mode));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes', 'url' => 'reservation_control', 'form_name' => 'reservation_control', 'display_name' => $title]);
        return view($view)->with(['model_name' => $data, 'modal_class' => $mode == "Edit" ? 'modal-lg' : '', 'collection' => $collection, 'rows' => $rows]);
    }


    public function get_rows($model, $form_type)
    {
        $program = ['Trainee', 'Guest', 'Visitor', 'Volunteer', 'Project Student', 'Staff', 'Others'];
        $program_purpose = array_combine($program, $program);
        $training = db::table('master_training')->pluck('training', 'id');
        if ($form_type == "Edit") {
            $user_details = DB::table('users')->where('id', $model->user_id)->pluck('user_name', 'id');
        } else {
            $user_details = [];
        }
        $i = 0;
        $rows[$i][] = array('field_name' => 'checkin_date', 'label_name' => 'Checkin Date', 'field_type' => 'text', 'placeholder' => 'Select CheckIn Date', 'class_name' => 'required date-time-picker');
        $rows[$i][] = array('field_name' => 'checkout_date', 'label_name' => 'Checkout Date', 'field_type' => 'text', 'placeholder' => 'Select Checkout Date', 'class_name' => 'required date-time-picker');
        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Reservation Status', 'values_data' => ['0' => 'Waiting', '1' => 'Confirmed', '5' => 'Cancelled'], 'class_name' => 'select2 required');
        $i++;
        $rows[$i][] = array('field_name' => 'user_id', 'label_name' => 'Select User', 'field_type' => 'select', 'placeholder' => 'Select User', 'values_data' => $user_details, 'class_name' => 'select2 required', 'id' => 'user_id', 'url' => 'list_users/3');
        $rows[$i][] = array('field_name' => 'program_purpose', 'label_name' => 'Program Purpose', 'field_type' => 'select', 'placeholder' => 'Select Program Purpose', 'values_data' => $program_purpose, 'class_name' => 'select2 required');
        $rows[$i][] = array('field_name' => 'organization', 'label_name' => 'Organization', 'field_type' => 'text', 'placeholder' => 'Enter Organization', 'class_name' => '');
        $i++;
        $rows[$i][] = array('field_name' => 'training_id', 'label_name' => 'Training', 'field_type' => 'select', 'placeholder' => 'Select Training', 'values_data' => $training, 'class_name' => 'select2');
        $rows[$i][] = array('field_name' => 'course_name', 'label_name' => 'Course Name', 'field_type' => 'text', 'placeholder' => 'Enter Course Name', 'class_name' => '');
        $rows[$i][] = array('field_name' => 'contact_person', 'label_name' => 'Contact Person', 'field_type' => 'text', 'placeholder' => 'Contact Person at Aravind', 'class_name' => 'required');
        $i++;
        $rows[$i][] = array('field_name' => 'contact_person_mobileno', 'label_name' => 'Contact Person Mobile No', 'field_type' => 'text', 'placeholder' => 'Contact Person Mobile No', 'class_name' => '');
        $rows[$i][] = array('field_name' => 'contact_person_email', 'label_name' => 'Contact Person Email', 'field_type' => 'text', 'placeholder' => 'Contact Person Email', 'class_name' => '');
        $rows[$i][] = array('field_type' => 'empty');
        return $rows;
    }


    public function update(Request $request, $id)
    {

        $checkin_date =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
        $checkout_date = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
      
        if($checkin_date>$checkout_date)
        return array(
            'status' => FALSE,
            'notification' => "Please check the Checkin Date and Checkout Date!",
        );


        
        $validator = Validator::make($request->all(), [
            'program_purpose' => 'required',
            'contact_person_email' => 'email',
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        $current = Carbon::now();
        $data = $request->only('program_purpose', 'organization', 'training_id', 'course_name', 'contact_person', 'contact_person_mobileno', 'contact_person_email', 'additional_information', 'status');
        $data['checkin_date'] =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
        $data['checkout_date'] = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
        $data['updated_at'] = $current;
        DB::table('reservations')->where('id', $id)->update($data);
        $data2 = $request->only('status');
        $data2['checkin_date'] =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
        $data2['checkout_date'] = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
        $data2['updated_at'] = $current;
        DB::table('bookings')->where('reservation_id', $id)->update($data2);
        $user = DB::table('users')->join('reservations', 'reservations.user_id', 'users.id')->where('reservations.id', $id)->select('users.mobile_no', 'users.email', 'users.display_name')->first();
        if ($request->status == 1) {
            $message = 'Your Reservation #' . $id . " was confirmed. Please login into the website and pay the amount. ";
        } elseif ($request->status == 2) {
            $message = 'Welcome to Laico. Your Reservation #' . $id . " checkin success.";
        } elseif ($request->status == 3) {
            $message = 'Welcome to Laico. Your Reservation #' . $id . " checkout success.";
        } elseif ($request->status == 5) {
            $message = 'Your Reservation #' . $id . " was cancelled. To know further contact our helpline.";
        }
        if (isset($message)) {

            Mail::to($user->email)->queue(new SendStatus($user, $message));
            $message .= " Cheers,  Team Laico";
            $smsdata = Helpers::sendsms($user->mobile_no, $message);
        }
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Reservation details successfully updated...");
        }
        return redirect(route('master_aravind_centres.index'))->with('message', 'Reservation details successfully updated...!');
    }


    public function destroy(Request $request, $id)
    {
        DB::table('bookings')->where('reservation_id', $id)->delete();
        DB::table('reservations')->where('id', $id)->delete();
        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Reservation Details successfully deleted.");
        }
        return redirect(route('reservation_control.index'))->with('message', 'Reservation control successfully Deleted...!');
    }


}
