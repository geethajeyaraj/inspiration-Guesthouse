<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;


class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

	public function index()
    {
      $preferences = DB::table('preferences')->where('category_id', 1)->get();
      $settings = MapColumns($preferences, 'key','value');
	  return view('settings.index')->with('settings',$settings);
    }

	public function update(Request $request)
    {
        $post = $request->except('login_logo','dashboard_logo','favicon');
        $i = 0;
        foreach ($post as $key => $value) {
            $data['value'] = $value;

            DB::table('preferences')->updateOrInsert(['category_id' => 1, 'key'=>$key],$data);
        
        }
        $images=array('login_logo','dashboard_logo','favicon');
        for($i=0;$i<count($images);$i++)
        {

            $data=[];
            $file = $request->file($images[$i]);
            if (isset($file)) {
               $path = $request->file($images[$i])->store('settings', 'public');
               $data['value'] =$path;
               DB::table('preferences')->updateOrInsert(['category_id' => 1, 'key'=>$images[$i]],$data);
           }

        }

        return redirect()->route('settings')->with('success', 'Settings successfully Updated');
    }







}
