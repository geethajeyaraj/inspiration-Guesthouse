<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DataTables;
use DB;
use Validator;

use App\Models\User;



class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        $user = auth()->user();
        $countries= DB::table("master_countries")->pluck('country_name', 'id');
    
        $states=array();
        if(isset($user->state))
        $states=DB::table("master_states")->where('id',$user->state)->pluck('state_name', 'id');

        $cities=array();
        if(isset($user->city))
        $cities=DB::table("master_cities")->where('id',$user->city)->pluck('city_name', 'id');



        $centres= DB::table("master_aravind_centres")->pluck('centre_name', 'id');
        $id_proofs= DB::table("master_id_proofs")->pluck('id_proof_name', 'id');


        return view('myprofile')->with(['model_name' => $user,  'countries' => $countries,'centres'=>$centres,'id_proofs'=>$id_proofs, 'cities' => $cities ,'states' => $states  ]);
    }

    public function update(Request $request)
    {


        $user = auth()->user();
        $user->title=$request->title;
        $user->display_name=$request->display_name;
        $user->email=$request->email;
        $user->mobile_no=$request->mobile_no;
        $user->gender=$request->gender;
        $user->land_line=$request->land_line;
        $user->nationality=$request->nationality;
        $user->address_line1=$request->address_line1;
        $user->address_line2=$request->address_line2;
        $user->pincode=$request->pincode;

        $user->country=$request->country;
        $user->state=$request->state;
        $user->city=$request->city;




        $user->guest_type=$request->guest_type;
        $user->staff_type=$request->staff_type;
     
        $user->center_id=$request->center_id;
        
        $user->department=$request->department;
        $user->designation=$request->designation;
        $user->id_proof=$request->id_proof;
        $user->id_proof_no=$request->id_proof_no;

        $file_location=$request->file('id_proof_location');


        if (isset($file_location)) {

        $user->id_proof_location=$request->file('id_proof_location')->store('id_proof', 'public');
        }
     


        $user->save();



        

        return array(
            'status' => true,
            'notification' => "Profile successfully updated.",
        );

        

    }





}
