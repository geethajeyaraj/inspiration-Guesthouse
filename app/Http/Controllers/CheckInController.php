<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;


class CheckInController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index($type, Request $request)
    {

        if ($request->ajax()) {
            return $this->show_data($type, $request);
        } else {
            return view('index')->with($this->get_data($type));
        }
    }

    public function show_data($type, $request)
    {
        $data = DB::table('bookings as r')->leftJoin('transaction_details as t','t.reservation_id','r.id')->select('r.id','r.checkin_date','r.checkout_date','r.total_amount', 'display_name', 'mobile_no', 'email','r.reservation_id','r.room_no',DB::raw('ifnull(sum(case when payment_type=1 then amount else null end),0)-ifnull(sum(case when payment_type=0 then amount else null end),0) as paid'),DB::raw('r.total_amount-ifnull(sum(case when payment_type=1 then amount else null end),0)-ifnull(sum(case when payment_type=0 then amount else null end),0) as balance_to_be_paid'))->groupBy('r.id','r.checkin_date','r.checkout_date','r.total_amount', 'display_name', 'mobile_no', 'email','r.reservation_id','r.room_no');



        if ($type == "upcoming") {

            if ($request->checkin_date != "") {
                $data->whereDate('checkin_date', '=', Carbon::createFromFormat('d/m/Y', $request->checkin_date));
            } else {
                $data->whereDate('checkin_date', '>=',  Carbon::now() );
            }
            $data->where('status',1);

       } elseif ($type == "history") {

           $data->whereNotIn('status',[0,5]);

       }
        elseif ($type == "checkin") {

            if ($request->checkin_date != "") {
                $data->whereDate('checkin_date', '=', Carbon::createFromFormat('d/m/Y', $request->checkin_date));
            } else {
                $data->whereDate('checkin_date', '=',  Carbon::now() );
            }

            $data->where('status',1);


        } elseif ($type == "checkout") {

            if ($request->checkout_date != "") {
                $data->whereDate('checkout_date', '=',Carbon::createFromFormat('d/m/Y', $request->checkout_date));
            } else {
                $data->whereDate('checkout_date','=', Carbon::now());
            }


            $data->where('status',2);



        } else {

            if ($request->checkin_date != "" ) {
                $data->whereRaw("'" . Carbon::createFromFormat('d/m/Y', $request->checkin_date) . "'  between checkin_date and checkout_date");
            } else {
                $data->whereRaw("'" . Carbon::now() . "' between checkin_date and checkout_date");
            }

            $data->where('status',2);

        }



        $datatables = Datatables::of($data);


        $datatables->editColumn('checkin_date', function ($a) {
            return with(new Carbon($a->checkin_date))->format('d/m/Y h:i A');
        });

        $datatables->editColumn('checkout_date', function ($a) {
            return with(new Carbon($a->checkout_date))->format('d/m/Y h:i A');
        });

     //   $datatables->addColumn('balance_to_be_paid', function ($sdata) {
     //       return   $sdata->total_amount- $sdata->paid;
      //  });



        $datatables->addColumn('action', function ($sdata) use ($type){

            $action='<span class="dropdown"><a href="#" class="btn btn-sm btn-primary btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false"><i class="la la-ellipsis-h"></i></a><div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >';

            $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("reservation_control.show", $sdata->reservation_id) . '"><i class="la la-eye"></i> View</a>';

            if ($type=="history") {            
                $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("bookings.edit", [$sdata->reservation_id,$sdata->id]) . '?status_update=allcheckin"><i class="la la-table"></i> Edit Checkin</a>';
            }
            else 
            {
                $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("bookings.edit", [$sdata->reservation_id,$sdata->id]) . '?status_update=checkin"><i class="la la-table"></i> Edit Checkin</a>';

                $action=$action.'<a  class="dropdown-item ajax-popup" href="' . route("bookings.edit", [$sdata->reservation_id,$sdata->id]) . '?status_update=checkinstatus"><i class="la la-table"></i> Update Status</a>';

            }

            
            $action=$action.'<a  class="dropdown-item" href="' . route("transaction_details.index", [$sdata->id]) . '"><i class="la la-table"></i> Edit Transactions</a>';
            
            $action=$action.'<a  class="dropdown-item  ajax-popup" href="' . route("bookings.edit", [$sdata->reservation_id,$sdata->id]) . '?mode=editdate"><i class="la la-table"></i> Edit details</a>';

             $action=$action.'</div></span>';

             return $action;


        });
        return $datatables->make(true);
    }

    public function get_data($type)
    {
        if($type=="upcoming")
        $data['title'] = "Upcoming checkins";
        elseif($type=="history")
        $data['title'] = "All Bookings";

        else
        $data['title'] = "Today " . $type;
       


        $data['data_url'] = route('today_checkin_checkout', $type);
        $data['responsive'] = True;

        $fields[] = array('id' => "id", 'name' => "r.id", 'display_name' => "ID");

        $fields[] = array('id' => "action", 'name' => "action", 'display_name' => "Action", 'orderable' => "false", 'searchable' => "false");

        if($type!="checkout")
        $fields[] = array('id' => "checkin_date", 'name' => "checkin_date", 'display_name' => "CheckIn Date", 'is_date' => true);
        else 
        $fields[] = array('id' => "checkin_date", 'name' => "checkin_date", 'display_name' => "CheckIn Date",  'orderable' => "false", 'searchable' => "false");
        
        if($type=="checkout")
        $fields[] = array('id' => "checkout_date", 'name' => "checkout_date", 'display_name' => "CheckOut Date", 'is_date' => true);
        else 
        $fields[] = array('id' => "checkout_date", 'name' => "checkout_date", 'display_name' => "CheckOut Date",  'orderable' => "false", 'searchable' => "false");


        $fields[] = array('id' => "room_no", 'name' => "room_no", 'display_name' => "Room No");



        $fields[] = array('id' => "total_amount", 'name' => "total_amount", 'display_name' => "Total Amount");
       $fields[] = array('id' => "paid", 'name' => "paid", 'display_name' => "Paid Amount", 'searchable' => "false");

       $fields[] = array('id' => "balance_to_be_paid", 'name' => "balance_to_be_paid", 'display_name' => "Balance", 'searchable' => "false");
        

        $fields[] = array('id' => "display_name", 'name' => "r.display_name", 'display_name' => "Reserved By");
        $fields[] = array('id' => "mobile_no", 'name' => "r.mobile_no", 'display_name' => "Mobile No");

        $fields[] = array('id' => "email", 'name' => "r.email", 'display_name' => "Email");

    

        $data['fields'] = $fields;
        $data['post_type'] = 'get';
        $data['order_id'] = "2";
        $data['order_status'] ="Desc";



        return $data;
    }
}
