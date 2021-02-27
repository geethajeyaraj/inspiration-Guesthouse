<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class ReservationTransactionController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id,Request $request)
    {

        if ($request->ajax()) {
            return $this->show_data($id,$request);
        } else {
            return view('index')->with($this->get_data($id));
        }

        
    }

    public function show_data($id,$request)
    {
        $data = DB::table('transaction_details')->where('reservation_id',$id);
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
            <a  class="dropdown-item ajax-popup" href="' . route("transaction_details.edit", [$sdata->reservation_id, $sdata->id]) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data($id)
    {

        


        $data['title']='Payment Transactions for Booking <a class="ajax-popup" href="' . route("reservation_control.show", $id) . '"></i>   #'.$id.'</a>';

        $data['data_url']=route('transaction_details.index',$id);

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");

        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

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
        $data['permission'] = 'master';
        $data['create_url'] = route('transaction_details.create',$id);
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('transaction_details.destroy', [$id,"delete_id"]);
        $data['post_type'] = 'get';

        $data['hide_columns'] ="6,7,8,9";

        return $data;

    }


    public function create($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows($id, 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('transaction_details.index',$id),'form_name'=>'master','display_name'=>'Transaction']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store($id,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_date' => 'required',
            'mode_of_payment' => 'required',
            'payment_type' => 'required',
            'amount' => 'required'
            

        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $data = $request->only('mode_of_payment', 'payment_type', 'amount', 'is_collected', 'payment_ref_no', 'description');

        $data['transaction_date']= Carbon::createFromFormat('d/m/Y h:i A',$request->transaction_date)->format('Y-m-d H:i:s');

        if($request->payment_ref_date!="")
        $data['payment_ref_date']= Carbon::createFromFormat('d/m/Y h:i A',$request->payment_ref_date)->format('Y-m-d H:i:s');

        if($request->collection_date!="")
        $data['collection_date']= Carbon::createFromFormat('d/m/Y h:i A',$request->collection_date)->format('Y-m-d H:i:s');



        $data['reservation_id']=$id;
        $data['created_at']= $current;

        DB::table('transaction_details')->insert($data);


   



        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Transaction successfully added.",
            );
        } 
        return redirect()->route('transaction_details.index')->with('message', 'Transaction successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($reservation_id, $id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $model_name = DB::table('transaction_details')->where('id',$id)->first();
     

        $model_name->transaction_date  = Carbon::parse($model_name->transaction_date)->format('d/m/Y h:i A');
    
        if($model_name->payment_ref_date!="")
        $model_name->payment_ref_date = Carbon::parse($model_name->payment_ref__date)->format('d/m/Y h:i A');
    
        if($model_name->collection_date!="")
        $model_name->collection_date = Carbon::parse($model_name->collection_date)->format('d/m/Y h:i A');
    
        
        $rows = collect($this->get_rows($model_name, 'Edit'));
        
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','update_url'=>route('transaction_details.update',[$reservation_id, $id]),'delete_url'=>route('transaction_details.destroy',[$reservation_id, $id]),'form_name'=>'master','display_name'=>'Reservation Transaction #'.$reservation_id]);
        return view($view)->with(['model_name' => $model_name, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($model_name, $form_type)
    {

        $i=0;
 
        $rows[$i][] = array('field_name' => 'transaction_date', 'label_name' => 'Transaction Date', 'field_type' => 'text', 'placeholder' => 'Select Transaction Date','class_name' => 'date-time-picker required');

        $rows[$i][] = array('field_name' => 'mode_of_payment', 'label_name' => 'Mode of Payment', 'field_type' => 'select', 'placeholder' => 'Select Mode of Payment','values_data'=>['0'=>"Cash",1=>"Online",2=>"Cheque",3=>"DD"], 'class_name' => 'select2 required');

        $i++;
        $rows[$i][] = array('field_name' => 'amount', 'label_name' => 'Amount', 'field_type' => 'text', 'placeholder' => 'Enter amount', 'class_name' => 'number required');

      
        $rows[$i][] = array('field_name' => 'payment_type', 'label_name' => 'Payment Type', 'field_type' => 'select', 'placeholder' => 'Select Payment Type','values_data'=> [1=>'Credit',0=>'Refund'], 'class_name' => 'select2 required');

        $i++;
        $rows[$i][] = array('field_name' => 'is_collected', 'label_name' => 'DD/Cheque Collected?', 'field_type' => 'select', 'placeholder' => 'Select','values_data'=> [1=>'Yes'], 'class_name' => 'select2');

        $rows[$i][] = array('field_name' => 'payment_ref_no', 'label_name' => 'DD/Cheque/Online no', 'field_type' => 'text', 'placeholder' => 'Payment Ref No', 'class_name' => '');

        $i++;
        $rows[$i][] = array('field_name' => 'payment_ref_date', 'label_name' => 'DD/Cheque/Online Date', 'field_type' => 'text', 'placeholder' => 'Select ','class_name' => 'date-time-picker');

        $rows[$i][] = array('field_name' => 'collection_date', 'label_name' => 'Collection Date', 'field_type' => 'text', 'placeholder' => 'Select','class_name' => 'date-time-picker');

        $i++;
        $rows[$i][] = array('field_name' => 'description', 'label_name' => 'Description', 'field_type' => 'text', 'placeholder' => 'Enter Description', 'class_name' => '');


           



        return $rows;
    }


    
    public function update(Request $request,$reservation_id, $id)
    {
        $validator = Validator::make($request->all(), [
            
            'transaction_date' => 'required',
            'mode_of_payment' => 'required',
            'payment_type' => 'required',
            'amount' => 'required'



        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $data = $request->only('mode_of_payment', 'payment_type', 'amount', 'is_collected', 'payment_ref_no', 'description');

        $data['transaction_date']= Carbon::createFromFormat('d/m/Y h:i A',$request->transaction_date)->format('Y-m-d H:i:s');

        if($request->payment_ref_date!="")
        $data['payment_ref_date']= Carbon::createFromFormat('d/m/Y h:i A',$request->payment_ref_date)->format('Y-m-d H:i:s');

        if($request->collection_date!="")
        $data['collection_date']= Carbon::createFromFormat('d/m/Y h:i A',$request->collection_date)->format('Y-m-d H:i:s');




        $data['updated_at']= $current;
        DB::table('transaction_details')->where('id',$id)->update($data);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Transaction details successfully updated...");
        } 

        return redirect(route('reservation_rooms.index',$reservation_id))->with('message','Transaction details successfully updated...!');

    }

     public function destroy(Request $request,$reservation_id,$id)
    {
        DB::table('transaction_details')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Transaction Details successfully deleted.");
        }


        return redirect(route('transaction_details.index',$reservation_id))->with('message','Transaction details successfully Deleted...!');
    }

}
