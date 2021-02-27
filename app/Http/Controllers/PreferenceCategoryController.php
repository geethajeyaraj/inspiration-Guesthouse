<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use DB;
use Validator;

class PreferenceCategoryController extends Controller
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
        $data = DB::table('preference_categories');
        $datatables = Datatables::of($data);


        $datatables->addColumn('action', function ($sdata) {

            if($sdata->id>1)

            return '<span class="dropdown">
        <a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="dropdown" aria-expanded="false">
          <i class="la la-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" >
            <a  class="dropdown-item ajax-popup" href="' . route("preference_categories.edit", $sdata->id) . '"><i class="la la-edit"></i> Edit Details</a>
            <a class="dropdown-item" href="javascript:deletefun(' . $sdata->id . ')"><i class="la la-close"></i> Delete</a>
        </div>
    </span>';
    else

        return "";



        });
        return $datatables->make(true);
    }

    public function get_data()
    {
        $data['title'] = "Preference Categories";
        $data['data_url'] = route('preference_categories.index');
        $fields[] = array('id' => "id", 'name' => "id", 'display_name' => "ID");
        $fields[] = array('id' => "name", 'name' => "name", 'display_name' => "Name");
        $fields[] = array('id' => "action", 'name' => "action", 'display_name' => "Action", 'orderable' => "false", 'searchable' => "false");
        $data['fields'] = $fields;
        $data['permission'] = 'preference';
        $data['create_url'] = route('preference_categories.create');
        $data['is_ajax_create'] = 'yes';
        $data['delete_url'] = route('preference_categories.destroy', "delete_id");
        $data['post_type'] = 'get';
        return $data;

    }

    public function create(Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};
        $rows = collect($this->get_rows('', 'create'));
        $collection = collect(['form_type' => 'Create', 'url' => route('preference_categories.index'), 'form_name' => 'preference', 'display_name' => 'Preference Catgories']);

        return view($view)->with(['collection' => $collection, 'rows' => $rows]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $data = $request->only('name');
        $data['updated_at'] = $current;
        DB::table('preference_categories')->insert($data);

        if ($request->ajax()) {
            return array(
                'status' => true,
                'notification' => "Preference Data successfully added.",
            );

        }

            return redirect()->route('preference_categories.index')->with('message', 'Preference data successfully inserted...');

    }

    public function show($id)
    {
        //
    }

    public function edit($id, Request $request)
    {
        if ($request->ajax()) {$view = "ajaxedit";} else { $view = "edit";};
        $data = DB::table('preference_categories')->where('id', $id)->first();
        $rows = collect($this->get_rows($data, 'Edit'));
        $collection = collect(['form_type' => 'Edit', 'include_delete' => 'yes', 'url' => 'preference_categories', 'form_name' => 'preference', 'display_name' => 'Preference Categories']);
        return view($view)->with(['model_name' => $data, 'collection' => $collection, 'rows' => $rows]);

    }

    public function get_rows($model, $form_type)
    {

        $i = 0;

        $rows[$i][] = array('field_name' => 'name', 'label_name' => 'Name', 'field_type' => 'text', 'placeholder' => 'Category Name', 'class_name' => 'required');
        $rows[$i][] = array('field_type' => 'empty');


        return $rows;
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {if ($request->ajax()) {
            return array('status' => false, 'notification' => $validator->errors()->all());
        } else {
            return back()->withErrors($validator)->withInput();
        }
        }

        $current = Carbon::now();
        $data = $request->only('name');
        $data['updated_at'] = $current;
        DB::table('preference_categories')->where('id', $id)->update($data);

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Preference categories successfully updated...");
        }

        return redirect()->route('preference_categories.index')->with('message', 'Preference categories successfully updated...');


    }

    public function destroy($id, Request $request)
    {
        $id = DB::table('preference_categories')->where('id', $id)->delete();

        if ($request->ajax()) {
            return array('status' => true, 'notification' => "Preference categories successfully deleted.");
        }

        return redirect()->route('preference_categories.index')->with('message', 'Preference categories successfully deleted.');
    }
}
