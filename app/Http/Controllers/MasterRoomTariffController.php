<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Carbon\Carbon;
use Validator;

class MasterRoomTariffController extends Controller
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
        $data = DB::table('master_room_tariff_plan as p')->join('master_room_types as t','p.room_type_id','t.id')->select('p.*','t.room_type');
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
            <a  class="dropdown-item ajax-popup" href="' . route("master_room_tariff.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
            </div>
            </span>';
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title']="Master Room Tariff";
        $data['data_url']=route('master_room_tariff.index');

        $fields[]=array('id'=>"id", 'name'=>"p.id",'display_name'=>"ID");
        $condition1[] = array('field_name' => "row.period_master_id", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Daily Tariff</span>");
        $condition1[] = array('field_name' => "row.period_master_id", 'field_name_equal' => "2", 'display_name' => "<span class='badge badge-warning'>Weekly </span>");
        $condition1[] = array('field_name' => "row.period_master_id", 'field_name_equal' => "3", 'display_name' => "<span class='badge badge-danger'>Monthly </span>");
        $fields[] = array('id' => "period_master_id", 'name' => "p.period_master_id", 'display_name' => "Period Master", 'condition' => $condition1,'search_items'=>[1=>"Daily Tariff",2=>"Weekly Tariff",3=>"Monthly Tariff"]);



        $fields[]=array('id'=>"room_type", 'name'=>"t.room_type",'display_name'=>"Room type");
        $fields[]=array('id'=>"room_rent", 'name'=>"p.room_rent",'display_name'=>"Room Rent");
        $fields[]=array('id'=>"charges_extrabed", 'name'=>"p.charges_extrabed",'display_name'=>"Charges Extrabed");
        $fields[]=array('id'=>"tax_percentage", 'name'=>"p.tax_percentage",'display_name'=>"Tax Percentage");
        $fields[]=array('id'=>"effect_from", 'name'=>"p.effect_from",'display_name'=>"Effect From");
        

        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "1", 'display_name' => "<span class='badge badge-success'>Active</span>");
        $condition[] = array('field_name' => "row.status", 'field_name_equal' => "0", 'display_name' => "<span class='badge badge-danger'>Inactive</span>");
        $fields[] = array('id' => "status", 'name' => "p.status", 'display_name' => "Status", 'condition' => $condition);
      
        $fields[]=array('id'=>"action",'name'=>"action",'display_name'=>"Action",'orderable'=>"false",'searchable'=>"false");

        $data['fields'] = $fields;
        $data['permission'] = 'master';
        $data['create_url'] = route('master_room_tariff.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('master_room_tariff.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }


    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create','url'=> route('master_room_tariff.index'),'form_name'=>'master','display_name'=>'Room Tariff']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);
    }

     public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_master_id' => 'required',
            'room_type_id' => 'required',
            'room_rent' => 'required',
            'charges_extrabed' => 'required',
            'tax_percentage' => 'required',
            'effect_from' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }



        $current = Carbon::now();
        $child = $request->only('period_master_id','room_type_id','room_rent','charges_extrabed','tax_percentage','status');
        $child['updated_at']= $current;

        $child['effect_from']=  Carbon::createFromFormat('d/m/Y',$request->effect_from)->format('Y-m-d');
      

        DB::table('master_room_tariff_plan')->insert($child);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Tariff plan successfully added.",
            );
        } 
        return redirect()->route('master_room_tariff.index')->with('message', 'Centre details successfully inserted...');
  
    }

    public function show($id)
    {
        //
    }


    public function edit($id,Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};

        $data = DB::table('master_room_tariff_plan')->where('id',$id)->first();

        $data->effect_from = Carbon::parse($data->effect_from)->format('d/m/Y');


        $rows = collect($this->get_rows($data, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes','url'=>'master_room_tariff','form_name'=>'master','display_name'=>'Tariff Plan']);
        return view($view)->with(['model_name' => $data, 'collection' => $collection, 'rows' => $rows]);

    }


    public function get_rows($quiz, $form_type)
    {

        $room_types=DB::table('master_room_types')->pluck('room_type','id');

        $i=0;
        $rows[$i][] = array('field_name' => 'period_master_id', 'label_name' => 'Period', 'field_type' => 'select', 'placeholder' => 'Select Period', 'values_data'=>[1=>"Daily Tariff",2=>"Weekly Tariff",3=>"Monthly Tariff"], 'class_name' => 'select2 required');

        $rows[$i][] = array('field_name' => 'room_type_id', 'label_name' => 'Room Type', 'field_type' => 'select', 'placeholder' => 'Select Room Type', 'values_data'=> $room_types , 'class_name' => 'select2 required');
        
        $i++;
        
        $rows[$i][] = array('field_name' => 'room_rent', 'label_name' => 'Room Rent', 'field_type' => 'text', 'placeholder' => 'Enter Room Rent', 'class_name' => 'required number');
        
        $rows[$i][] = array('field_name' => 'charges_extrabed', 'label_name' => 'Charges Extra Bed', 'field_type' => 'text', 'placeholder' => 'Extra Bed', 'class_name' => 'required number');
      
        $i++;
        
        $rows[$i][] = array('field_name' => 'tax_percentage', 'label_name' => 'Tax Percentage', 'field_type' => 'text', 'placeholder' => 'Enter Tax Percentage', 'class_name' => 'number required');
        
        $rows[$i][] = array('field_name' => 'effect_from', 'label_name' => 'Effect From', 'field_type' => 'text', 'placeholder' => 'Effect From', 'class_name' => 'date-picker required');
       
$i++;

        $rows[$i][] = array('field_name' => 'status', 'label_name' => 'Status', 'field_type' => 'select', 'placeholder' => 'Select Status','values_data'=>['1'=>'Active','0'=>'Inactive'], 'class_name' => 'select2 required');
       
        $rows[$i][] = array('field_type' => 'empty');
     


        return $rows;
    }


    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'period_master_id' => 'required',
            'room_type_id' => 'required',
            'room_rent' => 'required',
            'charges_extrabed' => 'required',
            'tax_percentage' => 'required',
            'effect_from' => 'required',
            'status' =>'required'
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $child = $request->only('period_master_id','room_type_id','room_rent','charges_extrabed','tax_percentage','status');

        
        $child['updated_at']= $current;

        $child['effect_from']=  Carbon::createFromFormat('d/m/Y',$request->effect_from)->format('Y-m-d');
      
        DB::table('master_room_tariff_plan')->where('id',$id)->update($child);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Tariff details successfully updated...");
        } 

        return redirect(route('master_room_tariff.index'))->with('message','Tariff details successfully updated...!');

    }

     public function destroy(Request $request,$id)
    {
        DB::table('master_room_tariff_plan')->where('id',$id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Tariff Details successfully deleted.");
        }


        return redirect(route('master_room_tariff.index'))->with('message','Tariff details successfully Deleted...!');
    }


}
