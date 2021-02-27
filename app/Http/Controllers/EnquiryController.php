<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class EnquiryController extends Controller
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
        $data = DB::table('enquiries');
        $datatables = Datatables::of($data);

        $datatables->addColumn('action', function ($sdata) {

      
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("enquiries.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Enquiries";
        $data['data_url']=route('enquiries.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"first_name", 'name'=>"first_name",'display_name'=>"First Name");
        $fields[]=array('id'=>"last_name", 'name'=>"last_name",'display_name'=>"Last Name");
        $fields[]=array('id'=>"phone_no", 'name'=>"phone_no",'display_name'=>"Phone no");
        $fields[]=array('id'=>"email", 'name'=>"email",'display_name'=>"Email");
        $fields[]=array('id'=>"message", 'name'=>"message",'display_name'=>"Message");
        $fields[]=array('id'=>"created_at", 'name'=>"created_at",'display_name'=>"Submit On");
        $fields[]=array('id'=>"action_taken", 'name'=>"action_taken",'display_name'=>"Action Taken");
      


        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'role';
        $data['create_url'] = route('enquiries.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('enquiries.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('enquiries.index'),'form_name'=>'master','display_name'=>'Enquiries']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' =>'required',
            'phone_no' =>'required',
            'email' =>'required',
            'message' =>'required',
            

        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('first_name','last_name','phone_no','email','message','action_taken');
        $child['updated_at']= $current;
        DB::table('enquiries')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Enquiry Successfully added.",
            );
        } 
        return redirect()->route('enquiries.index')->with('message', 'Enquiry successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $role = DB::table('enquiries')->where('id',$id)->first();
        $rows = collect($this->get_rows($role, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'enquiries','form_name'=>'master','display_name'=>'Enquiry Details']);
        return view($view)->with(['model_name' => $role, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][] = array('field_name' => 'first_name', 'label_name' => 'First Name', 'field_type' => 'text', 'placeholder' => 'Enter First Name', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'last_name', 'label_name' => 'Last Name', 'field_type' => 'text', 'placeholder' => 'Enter Last Name', 'class_name' => 'required');

        $i++;

        $rows[$i][] = array('field_name' => 'phone_no', 'label_name' => 'Phone No', 'field_type' => 'text', 'placeholder' => 'Enter phone_no', 'class_name' => 'required');
        $rows[$i][] = array('field_name' => 'email', 'label_name' => 'Email', 'field_type' => 'text', 'placeholder' => 'Enter email', 'class_name' => 'required');
        $i++;
        $rows[$i][] = array('field_name' => 'message', 'label_name' => 'Message', 'field_type' => 'textarea', 'placeholder' => 'Enter Message', 'class_name' => 'required');
        $i++;

        $rows[$i][] = array('field_name' => 'action_taken', 'label_name' => 'Action Taken', 'field_type' => 'text', 'placeholder' => 'Enter Action Taken', 'class_name' => '');



        

        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' =>'required',
            'phone_no' =>'required',
            'email' =>'required',
            'message' =>'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('first_name','last_name','phone_no','email','message','action_taken');
 
        $child['updated_at']= $current;
        DB::table('enquiries')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Enquiry details successfully updated...");
        } 

        return redirect(route('enquiries.index'))->with('message','Enquiry details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('enquiries')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Enquiry Details successfully deleted.");
        }


        return redirect(route('enquiries.index'))->with('message','Enquiry details successfully Deleted...!');
    }

}
