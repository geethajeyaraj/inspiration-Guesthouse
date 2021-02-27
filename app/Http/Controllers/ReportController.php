<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;
use App\Http\Helpers;


class ReportController extends Controller
{
    public function categorywiserooms(){
        $data['report'] = DB::table('master_room_details as p')->join('master_room_types as t','p.room_type_id','t.id')->select('t.room_type',DB::raw('count(*) as no_of_rooms'))->groupBy('t.room_type')->get();
        $data['title']="Categorywise Rooms";
        return view('reports')->with($data);
    }

    public function guestdetails(Request $request)
    {
        if ($request->ajax()) {
            return $this->show_guest($request);
        } else {
            return view('index')->with($this->get_guest());
        }
    }

    public function show_guest($request)
    {

        $data = DB::table('bookings')->select('id','checkin_date','checkout_date','title','display_name','gender','city','mobile_no','email')->where('status',2);


        $data->whereRaw( "'". Carbon::now() ."' between checkin_date and checkout_date");
        $datatables = Datatables::of($data);
        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-primary btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("reservation_control.show", $sdata->reservation_id) . '"><i class="la la-eye"></i> View</a>
         
            </div>
            </span>';
        
        });
        return $datatables->make(true);
    }

    public function get_guest()
    {
        $data['title']="Current CheckIn Guests";
        $data['data_url']=route('guestdetails');
        $data['responsive']=True;
        
        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");



        $fields[]=array('id'=>"checkin_date", 'name'=>"checkin_date",'display_name'=>"CheckIn Date",'is_date'=>true);
        $fields[]=array('id'=>"checkin_date", 'name'=>"checkin_date",'display_name'=>"CheckOut Date",'orderable'=>"false",'searchable'=>"false");

        $fields[]=array('id'=>"title", 'name'=>"title",'display_name'=>"Title");
        $fields[]=array('id'=>"display_name", 'name'=>"display_name",'display_name'=>"Name");
        $fields[]=array('id'=>"gender", 'name'=>"gender",'display_name'=>"Gender");
        $fields[]=array('id'=>"city", 'name'=>"city",'display_name'=>"City");
        $fields[]=array('id'=>"mobile_no", 'name'=>"mobile_no",'display_name'=>"Mobile No");
        $fields[]=array('id'=>"email", 'name'=>"email",'display_name'=>"Email");


     
        $data['fields'] = $fields;
        $data['post_type'] = 'get';
        return $data;
    }




    public function alltransactions(Request $request)
    {
        if ($request->ajax()) {
            return $this->show_transaction($request);
        } else {
            return view('index')->with($this->get_transaction());
        }
    }

    public function show_transaction($request)
    {

        $data = DB::table('transaction_details as t')->leftJoin('bookings as b','t.reservation_id','b.id')->select('t.*','display_name','mobile_no','email');


        $datatables = Datatables::of($data);


        if($request->transaction_date!="")
        {
            $data->whereDate('transaction_date', '=', Carbon::createFromFormat('d/m/Y', $request->transaction_date));
        }

        if($request->payment_ref_date!="")
        {
            $data->whereDate('payment_ref_date', '=', Carbon::createFromFormat('d/m/Y', $request->payment_ref_date));
        }


        if($request->collection_date!="")
        {
            $data->whereDate('collection_date', '=', Carbon::createFromFormat('d/m/Y', $request->collection_date));
        }




        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-primary btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("reservation_control.show", $sdata->reservation_id) . '"><i class="la la-eye"></i> View</a>
   
            </div>
            </span>';
        
        });
        return $datatables->make(true);
    }

    public function get_transaction()
    {
        $data['title']="All Payment Transactions";
        $data['data_url']=route('alltransactions');
        $data['responsive']=True;
        
        $fields[]=array('id'=>"id", 'name'=>"t.id",'display_name'=>"ID");


        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $fields[]=array('id'=>"reservation_id", 'name'=>"t.reservation_id",'display_name'=>"Reservaion ID");

        $fields[]=array('id'=>"display_name", 'name'=>"display_name",'display_name'=>"Name");
        $fields[]=array('id'=>"mobile_no", 'name'=>"mobile_no",'display_name'=>"Mobile No");

        $fields[]=array('id'=>"email", 'name'=>"email",'display_name'=>"Email");



        $fields[]=array('id'=>"transaction_date", 'name'=>"transaction_date",'display_name'=>"Transaction Date",'is_date'=>true);
        
        $fields[]=array('id'=>"amount", 'name'=>"amount",'display_name'=>"Amount");


        
       $condition[] = array('field_name' => "row.mode_of_payment", 'field_name_equal' => "0", 'display_name' => "Cash");
       $condition[] = array('field_name' => "row.mode_of_payment", 'field_name_equal' => "1", 'display_name' => "Online");
       $condition[] = array('field_name' => "row.mode_of_payment", 'field_name_equal' => "2", 'display_name' => "Cheque");
       $condition[] = array('field_name' => "row.mode_of_payment", 'field_name_equal' => "3", 'display_name' => "DD");
        $fields[]=array('id'=>"mode_of_payment", 'name'=>"mode_of_payment",'display_name'=>"Mode of Payment",'search_items'=>[0=>"Cash",1=>"Online",2=>"Cheque",3=>"DD"],'condition' => $condition);



        $condition1[] = array('field_name' => "row.payment_type", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Credit</span>");
        $condition1[] = array('field_name' => "row.payment_type", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Refund</span>");

        $fields[]=array('id'=>"payment_type", 'name'=>"payment_type",'display_name'=>"Payment Type",'search_items'=> [1=>'Credit',0=>'Refund'],'condition' => $condition1);


        $condition2[] = array('field_name' => "row.is_collected", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Yes</span>");

       
        $fields[]=array('id'=>"is_collected", 'name'=>"is_collected",'display_name'=>"Cheque/DD Collected?",'search_item'=> [1=>'Yes'],'condition' => $condition2);


        
        $fields[]=array('id'=>"payment_ref_no", 'name'=>"payment_ref_no",'display_name'=>"DD/Cheque/Online Ref No");

        $fields[]=array('id'=>"payment_ref_date", 'name'=>"payment_ref_date",'display_name'=>"DD/Cheque/Online Ref Date",'is_date'=>true);

        $fields[]=array('id'=>"collection_date", 'name'=>"collection_date",'display_name'=>"Collection Date",'is_date'=>true);
        
        
        $fields[]=array('id'=>"description", 'name'=>"description",'display_name'=>"Description");




     
        $data['fields'] = $fields;
        $data['post_type'] = 'get';
        return $data;
    }




    public function monthwisesummary(Request $request)
    {
        if ($request->ajax()) {
            return $this->show_monthwise($request);
        } else {
            return view('index')->with($this->get_monthwise());
        }
    }

    public function show_monthwise($request)
    {

        $data = DB::table('transaction_details')->select(DB::raw('year(transaction_date) as transaction_year'),DB::raw('monthname(transaction_date) as transaction_month'),DB::raw('sum(case when payment_type=1 then amount else null end) as credit'),DB::raw('sum(case when payment_type=0 then amount else null end) as refund'))->groupBy('transaction_year','transaction_month');




        $datatables = Datatables::of($data);

        return $datatables->make(true);
    }

    public function get_monthwise()
    {
        $data['title']="Monthwise Transaction summary";
        $data['data_url']=route('monthwisesummary');
        $data['responsive']=True;
        
    
        $fields[]=array('id'=>"transaction_year", 'name'=>"transaction_year",'display_name'=>"Year");

        $fields[]=array('id'=>"transaction_month", 'name'=>"transaction_month",'display_name'=>"Month");

        $fields[]=array('id'=>"credit", 'name'=>"credit",'display_name'=>"Credit");
        $fields[]=array('id'=>"refund", 'name'=>"refund",'display_name'=>"Refund");


        


     
        $data['fields'] = $fields;
        $data['post_type'] = 'get';
        return $data;
    }



    public function monthwiseguest(Request $request)
    {
        if ($request->ajax()) {
            return $this->show_monthwiseguest($request);
        } else {
            return view('index')->with($this->get_monthwiseguest());
        }
    }

    public function show_monthwiseguest($request)
    {

        $data = DB::table('bookings')->select(DB::raw('year(bookings.checkin_date) as checkin_year'),DB::raw('monthname(bookings.checkin_date) as checkin_month'),DB::raw('count(distinct bookings.id) as no_of_guests'))->groupBy('checkin_year','checkin_month');




        $datatables = Datatables::of($data);

        return $datatables->make(true);
    }

    public function get_monthwiseguest()
    {
        $data['title']="Monthwise Guest CheckIn";
        $data['data_url']=route('monthwiseguest');
        $data['responsive']=True;
        
    
        $fields[]=array('id'=>"checkin_year", 'name'=>"checkin_year",'display_name'=>"Year");

        $fields[]=array('id'=>"checkin_month", 'name'=>"checkin_month",'display_name'=>"Month");

        $fields[]=array('id'=>"no_of_guests", 'name'=>"no_of_guests",'display_name'=>"No of Guests");
         


     
        $data['fields'] = $fields;
        $data['post_type'] = 'get';
        return $data;
    }


    public function dependonroomstatus($type)
    {

        $data['report'] = DB::table('master_room_details as p')->join('master_room_types as t','p.room_type_id','t.id')->leftJoin('bookings as b',function($join){
            
            $join->on('b.room_no','p.room_no')->where('b.status',2)->whereRaw( "'". Carbon::now() ."' between b.checkin_date and b.checkout_date");

        })->select('t.room_type','p.room_no','t.color_code','b.display_name','b.id')->orderBy('room_type')->orderBy('room_no')->get();



        if ($type=="status") {

            $data['vacant']=0;
            $data['occupied']=0;

            foreach ($data['report'] as $r) {
                if ($r->display_name=='') {
                    $data['vacant']++;
                } else {
                    $data['occupied']++;
                }
            }

          

            return view('charts.dependonroomstatus')->with($data);



        }else{



            $room_types = DB::table('master_room_types as t')->get();
            
            $roomtype=array();

            foreach($room_types as $r)
            {
                $roomtype[$r->room_type]['vacant']=0;
                $roomtype[$r->room_type]['occupied']=0;
                $roomtype[$r->room_type]['color_code']=$r->color_code;

            }


           
            foreach ($data['report'] as $r) {
                if ($r->display_name=='') {
                    $roomtype[$r->room_type]['vacant']++;
                } else {
                    $roomtype[$r->room_type]['occupied']++;
                }
            }



            return view('charts.dependonroomtype')->with($data)->with('room_types',$roomtype);




        }



    }



}
