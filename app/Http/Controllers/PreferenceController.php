<?php

namespace App\Http\Controllers;

use App\Models\CategoryData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use DB;
use Validator;


class PreferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
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
        $data = DB::table('preferences')->join('preference_categories','preference_categories.id','preferences.category_id')->where('category_id',"<>",1)->select('preferences.*','preference_categories.name as category');
        $datatables = Datatables::of($data);


        $datatables->addColumn('action', function ($sdata) {
            return '<span class="dropdown">
        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
          <i class="la la-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("preferences.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit Details</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
        </div>
    </span>';
        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title'] = "Preference Details";
        $data['data_url'] = route('preferences.index');
        $fields[] = array('id' => "id", 'name' => "preferences.id", 'display_name' => "ID");
        $fields[] = array('id' => "category", 'name' => "preference_categories.name", 'display_name' => "Category");
        $fields[] = array('id' => "key", 'name' => "key", 'display_name' => "key");
        $fields[] = array('id' => "value", 'name' => "value", 'display_name' => "Value");
        $fields[] = array('id' => "action", 'name' => "action", 'display_name' => "Action", 'orderable' => "false", 'searchable' => "false");
        $data['fields'] = $fields;
        $data['permission'] = 'preference';
        $data['create_url'] = route('preferences.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('preferences.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }

    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};
        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create', 'url' => route('preferences.index'), 'form_name' => 'preference', 'display_name' => 'Preference Datas']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $data = $request->only('category_id','key','value');
        $data['updated_at'] = $current;
        DB::table('preferences')->insert($data);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Preference Data successfully added.",
            );

        }

            return redirect()->route('preferences.index')->with('message', 'Preference data successfully inserted...');

    }

    public function show($id)
    {
        //
    }

    public function edit($id, Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};
        $data = DB::table('preferences')->where('id', $id)->first();
        $rows = collect($this->get_rows($data, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes', 'url' => 'preferences', 'form_name' => 'preference', 'display_name' => 'Preference Datas']);
        return view($view)->with(['model_name' => $data, 'collection' => $collection, 'rows' => $rows]);

    }

    public function get_rows($model, $form_type)
    {

        $categories = DB::table('preference_categories')->pluck('name', 'id');

        $i = 0;

        $rows[$i][] = array('field_name' => 'category_id', 'label_name' => 'Category', 'field_type' => 'select', 'placeholder' => 'Select Category', 'values_data' => $categories, 'class_name' => 'select2 required', 'id' => 'categories');

        $rows[$i][] = array('field_name' => 'key', 'label_name' => 'Key', 'field_type' => 'text', 'placeholder' => 'Key Name', 'class_name' => 'required');

        $i++;
        $rows[$i][] = array('field_name' => 'value', 'label_name' => 'Value', 'field_type' => 'text', 'placeholder' => 'Value Name', 'class_name' => 'required');
        $rows[$i][] = array('field_type' => 'empty');


        return $rows;
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'key' => 'required',
            'value' => 'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $data = $request->only('category_id','key','value');
        $data['updated_at'] = $current;
        DB::table('preferences')->where('id', $id)->update($data);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Preference datas successfully updated...");
        }

        return redirect()->route('preferences.index')->with('message', 'Preference datas successfully updated...');


    }

    public function destroy($id, Request $request)
    {
        $id = DB::table('preferences')->where('id', $id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Preference datas successfully deleted.");
        }

        return redirect()->route('preferences.index')->with('message', 'Preference datas successfully deleted.');
    }
}
