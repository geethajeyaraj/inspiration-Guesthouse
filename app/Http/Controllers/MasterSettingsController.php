<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class MasterSettingsController extends Controller
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
        $data = DB::table('master_settings');
        $datatables = Datatables::of($data);
        $datatables->editColumn('effect_from', function ($a) {
            return with(new Carbon($a->effect_from))->format('d/m/Y');
        });
        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
            <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
            <i class="la la-ellipsis-h"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("master_settings.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Master Settings";
        $data['data_url']=route('master_settings.index');

        $fields[]=array('id'=>"id", 'name'=>"id",'display_name'=>"ID");
        $fields[]=array('id'=>"effect_from", 'name'=>"effect_from",'display_name'=>"Effect From");
        
        $fields[]=array('id'=>"food_amount", 'name'=>"food_amount",'display_name'=>"Food Amount");
        $fields[]=array('id'=>"food_tax_percentage", 'name'=>"food_tax_percentage",'display_name'=>"Food Tax Percentage");
        

        
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('master_settings.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('master_settings.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('master_settings.index'),'form_name'=>'master','display_name'=>'Setting Details']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'effect_from' => 'required',
            'food_amount' =>'required',
            'food_tax_percentage' =>'required',
            
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('food_amount','food_tax_percentage');
        $child['effect_from']=  Carbon::createFromFormat('d/m/Y',$request->effect_from)->format('Y-m-d');
      
        $child['updated_at']= $current;
        DB::table('master_settings')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Setting successfully added.",
            );
        } 
        return redirect()->route('master_settings.index')->with('message', 'Setting details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $data = DB::table('master_settings')->where('id',$id)->first();
        $data->effect_from = Carbon::parse($data->effect_from)->format('d/m/Y');



        $rows = collect($this->get_rows($data, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'master_settings','form_name'=>'master','display_name'=>'Master Settings']);
        return view($view)->with(['model_name' => $data, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {
        $i=0;
        $rows[$i][] = array('field_name' => 'effect_from', 'label_name' => 'Effect From', 'field_type' => 'text', 'placeholder' => 'Effect From', 'class_name' => 'date-picker required');
        $rows[$i][] = array('field_type' => 'empty');
    
        $i++;

        $rows[$i][] = array('field_name' => 'food_amount', 'label_name' => 'Food amount', 'field_type' => 'text', 'placeholder' => 'Enter Food amount', 'class_name' => 'number required');
        $rows[$i][] = array('field_name' => 'food_tax_percentage', 'label_name' => 'Food Tax Percentage', 'field_type' => 'text', 'placeholder' => 'Food Tax Percentage', 'class_name' => 'number required');
   
      
      
       

        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'effect_from' => 'required',
            'food_amount' =>'required',
            'food_tax_percentage' =>'required'
            
        ]);

        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('food_amount','food_tax_percentage');
        $child['effect_from']=  Carbon::createFromFormat('d/m/Y',$request->effect_from)->format('Y-m-d');
      
        $child['updated_at']= $current;
        DB::table('master_settings')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Setting details successfully updated...");
        } 

        return redirect(route('master_settings.index'))->with('message','Setting details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('master_settings')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Setting Details successfully deleted.");
        }


        return redirect(route('master_payments.index'))->with('message','Setting details successfully Deleted...!');
    }



}
