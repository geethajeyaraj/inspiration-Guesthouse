<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;


class MasterPaymentController extends Controller
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
        $data = DB::table('master_payment_details');
        $datatables = Datatables::of($data);

        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("master_payments.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Master Payment Details";
        $data['data_url']=route('master_payments.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"payment_details", 'name'=>"payment_details",'display_name'=>"Payment Details");
        
        $condition1[] = array('field_name' => "row.is_rent_payable", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Yes</span>");
        $condition1[] = array('field_name' => "row.is_rent_payable", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>No</span>");

        $fields[] = array('id' => "is_rent_payable", 'name' => "is_rent_payable", 'display_name' => "Rent Payable", 'condition' => $condition1);
      


        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "status", 'display_name' => "Status", 'condition' => $condition);
      
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('master_payments.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('master_payments.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('master_payments.index'),'form_name'=>'master','display_name'=>'Payment Details']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_details' => 'required',
            'is_rent_payable' =>'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('payment_details','status','is_rent_payable');
        $child['updated_at']= $current;
        DB::table('master_payment_details')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Payment successfully added.",
            );
        } 
        return redirect()->route('master_payments.index')->with('message', 'Payment details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $role = DB::table('master_payment_details')->where('id',$id)->first();
        $rows = collect($this->get_rows($role, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'master_payments','form_name'=>'master','display_name'=>'Master Payment']);
        return view($view)->with(['model_name' => $role, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][] = array('field_name' => 'payment_details', 'label_name' => 'Payment Details', 'field_type' => 'text', 'placeholder' => 'Enter Payment Details', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'is_rent_payable', 'label_name' => 'Is Rent Payable?', 'field_type' => 'select', 'placeholder' => 'Select Rent Payable','values_data'=>['1'=>'Yes','0'=>'No'], 'class_name' => 'select2 required');

        $i++;
        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>['1'=>'Active','0'=>'Inactive'], 'class_name' => 'select2 required');

        

        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_details' => 'required',
            'status' =>'required',
            'is_rent_payable' => 'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('payment_details','status','is_rent_payable');
        $child['updated_at']= $current;
        DB::table('master_payment_details')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Payment details successfully updated...");
        } 

        return redirect(route('master_payments.index'))->with('message','Payment details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('master_payment_details')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Payment Details successfully deleted.");
        }


        return redirect(route('master_payments.index'))->with('message','Payment details successfully Deleted...!');
    }




}
