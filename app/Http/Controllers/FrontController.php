<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Validator;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOTP;
use Carbon\Carbon;
use App\Http\Helpers;
use App\Mail\SendStatus;
use Illuminate\Support\Facades\Mail;
class FrontController extends Controller
{
    public  $merchant_id, $merchant_sub_id, $sign_key, $encryption_key, $encryption_iv, $token_generation_url, $txn_initiation_url;
    public function __construct()
    {
        $this->merchant_id = 'APIMER';
        $this->merchant_sub_id = 'LAIMDU';
        $this->sign_key = 'X4Ht74AracQNsWvGopO0gNdVcHoTDHJL';
        $this->encryption_key = hash('sha256', '4C9812076DE8BD35F31DD8326D8E86B5', true);
        $this->encryption_iv = 'uNTdeRP3QotvzbIL';
        $this->token_generation_url = 'https://www.iobnet.co.in/iobpay/iobpayRESTService/apitokenservice/generatenewtoken/';
        $this->txn_initiation_url = 'https://www.iobnet.co.in/iobpay/apitxninit.do';
    }
    public function index(Request $request)
    {
        return view('front_home');
    }
    public function getStates($id)
    {
        $states = DB::table("master_states")
            ->where("country_id", $id)
            ->pluck("state_name", "id");
        return response()->json($states);
    }
    //For fetching cities
    public function getCities($id)
    {
        $cities = DB::table("master_cities")
            ->where("state_id", $id)
            ->pluck("city_name", "id");
        return response()->json($cities);
    }
    public function ajax_login_register($type, Request $request)
    {
        if ($type == "ajaxregister")
            $type = "register";
        if ($request->ajax()) {
            return view('auth.ajax_login')->with(['type' => $type]);
        } else {
            return view('auth.login');
        }
    }
    public function resend_otp(Request $request)
    {
        $user = User::where('id', session('user_id'))->first();
        if (!isset($user->email)) {
            return array('status' => false, 'notification' => 'Something went wrong! Login Again');
        }
        $otp = mt_rand(100000, 999999);
        $user->otp_no = $otp;
        $user->save();
        session(['user_id' => $user->id]);
        Mail::to($user)->queue(new SendOTP($user));
        $message = 'Greetings from LAICO,You are receiving this message because you requested OTP for our LAICO login page. Please use the below details to access your account,';
        $message .= '     OTP  :' . $otp . '     ';
        $message .= " Cheers,  Team Laico";
        $smsdata = Helpers::sendsms($user->mobile_no, $message);
        return array('status' => true, 'notification' => 'OTP has been re-sent to your email', 'content' => 'OTP');
    }
    public function ajax_submit($type, Request $request)
    {
        if ($type == "login") {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
            ]);
        } elseif ($type == "otp") {
            $validator = Validator::make($request->all(), [
                'otp_no' => 'required',
            ]);
        } else {
            $type == "register";
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['required', 'string', 'min:6'],
                'mobile_no' => ['required', 'string', 'unique:users'],
                'display_name' => ['required', 'string'],
            ]);
        }
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }
        if ($type == "login") {
            $user = User::where('email', $request->email)->orWhere('mobile_no', $request->email)->first();
            if (!isset($user->email)) {
                return array('status' => false, 'notification' => 'Please register your email first', 'content' => 'REGISTER');
            }
            $otp = mt_rand(100000, 999999);
            $user->otp_no = $otp;
            $user->save();
            session(['user_id' => $user->id]);
            Mail::to($user)->queue(new SendOTP($user));
            if ($user->country == 101) {
                $message = 'Greetings from LAICO,You are receiving this message because you requested OTP for our LAICO login page. Please use the below details to access your account,';
                $message .= '     OTP  :' . $otp . '     ';
                $message .= " Cheers,  Team Laico";
                Helpers::sendsms($user->mobile_no, $message);
            }
            return array('status' => true, 'notification' => 'OTP has been sent to your email', 'content' => 'OTP');
        } elseif ($type == "otp") {
            $user = User::where('id', session('user_id'))->first();
            if (!isset($user->email)) {
                return array('status' => false, 'notification' => 'Session Expired. Refresh your page');
            }
            if ($user->otp_no == $request->otp_no) {
                $user->status = 1;
                $user->save();
                Auth::login($user);
                return array('status' => true, 'notification' => 'Login Success', 'content' => view('login_status')->render());
            } else {
                return array('status' => false, 'notification' => 'Please check OTP');
            }
        } else {
            $type == "register";
            $user = User::create([
                'user_name' => $request->email,
                'email' => $request->email,
                'password' => Hash::make(mt_rand(100000, 999999)),
                'role_id' => '3',
                'display_name' =>  $request->display_name,
                'mobile_no' => $request->mobile_no,
                'status' => 1,
            ]);;
            $otp = mt_rand(100000, 999999);
            $user->otp_no = $otp;
            $user->save();
            session(['user_id' => $user->id]);
            Mail::to($user)->queue(new SendOTP($user));
            if ($user->country == 101) {
                $message = 'Greetings from LAICO,You are receiving this message because you requested OTP for our LAICO login page. Please use the below details to access your account,';
                $message .= '     OTP  :' . $otp . '     ';
                $message .= " Cheers,  Team Laico";
                Helpers::sendsms($user->mobile_no, $message);
            }
            return array('status' => true, 'notification' => 'OTP has been sent to your email', 'content' => 'OTP');
        }
    }
    public function reservation()
    {
        $program = ['Trainee', 'Guest', 'Visitor', 'Volunteer', 'Project Student', 'Staff', 'Others'];
        $program_purpose = array_combine($program, $program);
        $training = db::table('master_training')->pluck('training', 'id');
        return view('reservation.index')->with(['program_purpose' => $program_purpose, 'training' => $training]);
    }
    public function getBeneficiary(Request $request)
    {
        $no_of_persons = $request->no_of_persons;
        $countries = DB::table("master_countries")->pluck('country_name', 'id');
        $states = array();
        $cities = array();
        $id_proofs = DB::table("master_id_proofs")->where('status', 1)->pluck('id_proof_name', 'id');
        $room_types = db::table('master_room_types as t')->pluck('room_type', 'id');
        $payments = db::table('master_payment_details')->pluck('payment_details', 'id');
        return view('reservation.beneficiary')->with(['no_of_persons' => $no_of_persons, 'countries' => $countries, 'id_proofs' => $id_proofs, 'cities' => $cities, 'states' => $states, 'room_types' => $room_types, 'payments' => $payments]);
    }
    public function submit_reservation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'checkin_date' => 'required',
            'checkout_date' => 'required',
            'program_purpose' => 'required',
            'contact_person' => 'required',
            "title"    => "required|array",
            "display_name"  => "required|array",
            "email"  => "required|array",
            "mobile_no"  => "required|array",
            "gender"  => "required|array",
            "nationality"  => "required|array",
            "country"  => "required|array",
            "state"  => "required|array",
            "city"  => "required|array",
            "address_line1"  => "required|array",
            "pincode"  => "required|array",
            "guest_or_trainee"  => "required|array",
            "id_proof"  => "required|array",
            "id_proof_no"  => "required|array",
            "payment_mode_id"  => "required|array",
            "room_type_id"  => "required|array",
            "meal_needed"  => "required|array",
            "payment_mode_id.*"  => "required",
            "room_type_id.*"  => "required",
            "meal_needed.*"  => "required",
            "title.*"  => "required|string",
            "display_name.*"  => "required|string",
            "email.*"  => "required|email",
            "mobile_no.*"  => "required|string",
            "gender.*"  => "required|string",
            "nationality.*"  => "required|string",
            "country.*"  => "required",
            "state.*"  => "required",
            "city.*"  => "required",
            "address_line1.*"  => "required|string",
            "pincode.*"  => "required|string",
            "guest_or_trainee.*"  => "required|string",
            "id_proof.*"  => "required|string",
            "id_proof_no.*"  => "required|string",
        ]);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return array('status' => false, 'notification' => $validator->errors()->all());
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }


        $start  =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date);
        $end = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date);

        if($start>$end)
        return array(
            'status' => FALSE,
            'notification' => "Please check the Checkin Date and Checkout Date!",
        );



        $no_of_hours = $start->diffInMinutes($end) / 60;
        if ($no_of_hours > 0)
            $no_of_days = ceil($no_of_hours / 24);
        else
            return array(
                'status' => FALSE,
                'notification' => "Please check the Checkin Date and Checkout Date!",
            );


      
        DB::beginTransaction();
        try {
            $current = Carbon::now();
            $data = $request->only(
                'program_purpose',
                'organization',
                'contact_person',
                'contact_person_mobileno',
                'contact_person_email',
                'training_id',
                'course_name',
                'additional_information'
            );
            $data['user_id'] = auth()->user()->id;
            $data['created_at'] = $current;
            $data['checkin_date'] =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
            $data['checkout_date'] = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
            $reservation = DB::table('reservations')->insertGetId($data);
            for ($i = 0; $i < count($request->title); $i++) {
                $users = array();
                $users['reservation_id'] = $reservation;
                $users['checkin_date'] =  Carbon::createFromFormat('d/m/Y h:i A', $request->checkin_date)->format('Y-m-d H:i:s');
                $users['checkout_date'] = Carbon::createFromFormat('d/m/Y h:i A', $request->checkout_date)->format('Y-m-d H:i:s');
                $users['payment_mode_id'] = $request->payment_mode_id[$i];
                $users['room_type_id'] = $request->room_type_id[$i];
                $users['meal_needed'] = $request->meal_needed[$i];
                $users['food_amount'] = 0;
                $users['food_tax'] = 0;
                $users['food_discount'] = 0;
                $users['room_rent'] = 0;
                $users['room_tax'] = 0;
                $users['room_discount'] = 0;
                $users['title'] = $request->title[$i];
                $users['display_name'] = $request->display_name[$i];
                $users['mobile_no'] = $request->mobile_no[$i];
                $users['email'] = $request->email[$i];
                $users['gender'] = $request->gender[$i];
                $users['land_line'] = $request->land_line[$i];
                $users['nationality'] = $request->nationality[$i];
                $users['address_line1'] = $request->address_line1[$i];
                $users['address_line2'] = $request->address_line2[$i];
                $users['country'] = $request->country[$i];
                $users['state'] = $request->state[$i];
                $users['city'] = $request->city[$i];
                $users['pincode'] = $request->pincode[$i];
                $users['guest_or_trainee'] = $request->guest_or_trainee[$i];
                $users['id_proof'] = $request->id_proof[$i];
                $users['id_proof_no'] = $request->id_proof_no[$i];
                $files = $request->file('id_proof_location');
                if (isset($files[$i]))
                    $users['id_proof_location'] = $files[$i]->store('id_proof', 'public');
                else
                    $users['id_proof_location'] = auth()->user()->id_proof_location;
                //  $users['id_proof_location']= '-';
                //$request->id_proof_location[$i]->store;
                $users['created_at'] = $current;
                $booking = DB::table('bookings')->insertGetId($users);
                Helpers::update_total_amount($booking);
            }
            //  
            $message = 'Greetings from LAICO, Your reservation order #R' . $reservation . " was success. We will update the status soon.";
            Mail::to(auth()->user()->email)->queue(new SendStatus(auth()->user(), $message));
            if (auth()->user()->country == 101) {
                $message .= " Cheers,  Team Laico";
                Helpers::sendsms(auth()->user()->mobile_no, $message);
            }
            // return $reservation;
            DB::commit();
            return array(
                'status' => true,
                'notification' => "Reservation completed, We will notify the registration status....",
            );
        } catch (\Exception $e) {
            DB::rollback();
            return array(
                'status' => false,
                'notification' => "Something went wrong!" . $e->getMessage(),
            );
        }
    }


    public function myreservations(Request $request)
    {
        $reservations = DB::table('reservations as r')->join('bookings as b', 'b.reservation_id', 'r.id')->where('r.user_id', auth()->user()->id)->select('r.id', 'r.checkin_date', 'r.checkout_date', 'r.created_at', 'b.title', 'b.display_name', 'b.gender', 'b.status', 'r.program_purpose')->orderBy('r.created_at', 'desc')->paginate(10);
        return view('myreservations')->with('reservations', $reservations);
    }


    public function mybookings(Request $request)
    {
      //  $reservations = DB::table('bookings as r')->select('r.id', 'r.checkin_date', 'r.checkout_date', 'r.created_at')->orderBy('r.created_at', 'desc')->whereNotIn('r.status', [0,5])->paginate(10);


        $reservations = DB::table('bookings as r')->leftJoin('transaction_details as t', 't.reservation_id', 'r.id')->select('r.id', 'r.checkin_date', 'r.checkout_date', 'r.total_amount', 'display_name', 'mobile_no', 'email', 'r.reservation_id', 'r.room_no', DB::raw('ifnull(sum(case when payment_type=1 then amount else null end),0)-ifnull(sum(case when payment_type=0 then amount else null end),0) as paid'), DB::raw('r.total_amount-ifnull(sum(case when payment_type=1 then amount else null end),0)-ifnull(sum(case when payment_type=0 then amount else null end),0) as balance_to_be_paid'))->where(function($query)
        {
            $query->where('email', auth()->user()->email)
            ->orWhere('mobile_no', auth()->user()->mobile_no);
        })->groupBy('r.id', 'r.checkin_date', 'r.checkout_date', 'r.total_amount', 'display_name', 'mobile_no', 'email', 'r.reservation_id', 'r.room_no')->whereNotIn('r.status', [0,5])->paginate(10);


        return view('mybookings')->with('reservations', $reservations);


    }


    public function show_page($page)
    {
        if ($page == "who-can-stay")
            return view('pages.whocanstay');
        elseif ($page == "tariff")
            return view('pages.tariff');
        elseif ($page == "information")
            return view('pages.information');
        elseif ($page == "contact")
            return view('pages.contact');
        elseif ($page == "success")
            return view('pages.success');
        else
            return redirect('/');
    }


    public function get_user_data()
    {
        return auth()->user();
    }


    public function view_receipt($id)
    {
        $data['reservations'] = DB::table('reservations')->join('users', 'users.id', 'reservations.user_id')->select('reservations.*', 'users.display_name', 'users.mobile_no', 'users.email')->where('reservations.id', $id)->first();
        $data['reservation_guests'] = DB::table('bookings')->join('master_room_types', 'master_room_types.id', 'bookings.room_type_id')->join('master_payment_details', 'master_payment_details.id', 'bookings.payment_mode_id')->where('bookings.reservation_id', $id)->select('bookings.*', 'master_room_types.room_type', 'master_payment_details.payment_details')->get();
        return view('reservation.view')->with($data);
    }


    public function contact_submit(Request $request)
    {
        $data = $request->only('first_name', 'last_name', 'email', 'phone_no', 'message');
        DB::table('enquiries')->insert($data);
        return redirect(url('success'));
    }


    public function view_invoice(Request $request, $id, $key)
    {
        $mykey = md5('laicokey' . $id);
        if ($mykey != $key) {
            return "Not allowed";
        }
        $data = array();
        $data['booking'] = DB::table('bookings')->where('id', $id)->first();
        $data['reservation'] = DB::table('reservations')->where('id', $data['booking']->reservation_id)->first();
        $data['room_type'] = DB::table('master_room_types')->where('id', $data['booking']->room_type_id)->first();


        $food = db::table('master_settings')->orderBy('effect_from', 'desc')->first();
        Carbon::setWeekendDays([Carbon::SUNDAY]);
        $start  = new Carbon($data['booking']->checkin_date);
        $end    = new Carbon($data['booking']->checkout_date);
        $no_of_hours = $start->diffInMinutes($end) / 60;
        $no_of_days = ceil($no_of_hours / 24);


        if ($data['booking']->meal_needed==1) {

            $food_days_condition = $start->diffInWeekendDays($end);
            if (!$start->isWeekend() && $start->format('H.i') > 21) {
                $food_days_condition = $food_days_condition + 1;
            }
            if (!$end->isWeekend() && $end->format('H.i') < 13) {
                $food_days_condition = $food_days_condition + 1;
            }
            if (!$start->isWeekend() && !$end->isWeekend() && (($start->format('H.i') < 21 && $end->format('H.i') < 13) || ($start->format('H.i') > 21 && $end->format('H.i') > 13))) {
                $food_days_condition = $food_days_condition - 1;
            }
            $food_no_of_days = 0;
            if ($no_of_days - $food_days_condition > 0) {
                $food_no_of_days = $no_of_days - $food_days_condition;
            }
            $food_amount = ($food->food_amount - $data['booking']->food_discount) * $food_no_of_days;
            $food_tax_amount = ($food->food_tax_percentage / 100) * ($food->food_amount - $data['booking']->food_discount) * $food_no_of_days;

        }
        else{

         
            $food_no_of_days = 0;
          
            $food_amount = 0;
            $food_tax_amount = 0;



        }



        $period_master_id = 1;
        if ($no_of_days >= 7) {
            $period_master_id = 2;
        } elseif ($no_of_days >= 30) {
            $period_master_id = 3;
        } else {
            $period_master_id = 1;
        }
        $room_amount = ($data['booking']->room_rent - $data['booking']->room_discount) * $no_of_days;
        $room_tax_amount = ($data['booking']->room_tax / 100) * ($data['booking']->room_rent - $data['booking']->room_discount) * $no_of_days;
        $total_amount = $food_amount + $food_tax_amount +  $room_amount + $room_tax_amount;
        $total_tax_amount = $food_tax_amount + $room_tax_amount;
        $data['food_amount'] =  $food->food_amount - $data['booking']->food_discount;
        $data['food_tax'] =  $food->food_tax_percentage;
        $data['food_no_of_days'] =  $food_no_of_days;
        $data['room_rent'] =  $data['booking']->room_rent - $data['booking']->room_discount;
        $data['room_tax'] =  $data['booking']->room_tax;
        $data['no_of_days'] =  $no_of_days;
        $data['total_amount'] =  $total_amount;
        $data['total_tax_amount'] =  $total_tax_amount;
        $data['period_master_id'] =   $period_master_id;
        $data['transaction_details'] = DB::table('transaction_details')->where('reservation_id', $data['booking']->id)->orderBy('transaction_date')->get();
        return view('reservation.invoice')->with($data);
    }


    public function paynow($booking_id, Request $request)
    {
          
        $current = Carbon::now();
        $txnid = auth()->user()->id . '_' . date("ymdHis");
        $fval = array();
        $fval["transaction_ref_id"] = $txnid;
        $fval["booking_id"] = $booking_id;
        $fval["amount"] = $request->amount;
        $fval["status"] = 0;
        $fval['created_at'] = $current;
        $result = DB::table('online_transactions')->insert($fval);
        if ($result == 1) {
            $redirect_url = url("iob/response");
               
               $feetype = "ALL FEES";
               
               $merchantreplyurl =  $redirect_url ; # merchant reply url to be replaced here
               $totalamt = $request->amount;

               $merchanttxnid = $txnid; // unique id to be generated by merchant for each txn . Ensure to save in db.
               $udf1 = ""; //any user defined value to be passed which may be used for future reference. Ex : Roll no , name , course, etc.
               $udf2 = ""; //any user defined value to be passed which may be used for future reference. Ex : Roll no , name , course, etc.
               $udf3 = ""; //any user defined value to be passed which may be used for future reference. Ex : Roll no , name , course, etc.
   
               $tokenId = "";
               


               $decodedData = generateToken($this->encryption_key,$this->encryption_iv,$this->sign_key,$this->merchant_id,$this->merchant_sub_id,$this->token_generation_url,$totalamt,$feetype,$merchantreplyurl);
         


               $tokenId = $decodedData->tokenid; //ensure to save in db

               $fval = array();
               $fval["token_id"] = $tokenId;
               DB::table('online_transactions')->where('transaction_ref_id',$txnid)->update($fval);

               

               
               if($tokenId != NULL)
               {
                       $txninitfinalString=initiateTxn($this->encryption_key,$this->encryption_iv,$this->sign_key,$this->merchant_id,$this->merchant_sub_id,$this->txn_initiation_url,$tokenId,$merchanttxnid,$udf1,$udf2,$udf3,$totalamt,$feetype);
               }
                   //start for txninit service
                   
    

            return view('payment.iob')->with(['txninitfinalString'=> $txninitfinalString,'txn_initiation_url'=>$this->txn_initiation_url]);

        } else {
            return "Something Went Wrong";
        }
    }

    public function payresponse(Request $request)
    {
        $responsejson = $_REQUEST['resjson'];
        logmessages("txninit response received : " . $responsejson);
        $decodedVal = json_decode($responsejson);
        $retData = $decodedVal->data;
        //$res = pkcs5_unpad(mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$encryption_key,base64_decode($retData), MCRYPT_MODE_CBC, $encryption_iv));
        $res = pkcs5_unpad(openssl_decrypt(base64_decode($retData), 'AES-256-CBC', $this->encryption_key, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $this->encryption_iv)); //php 7.1 and above
        //$res = pkcs5_unpad(mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$encryption_key,base64_decode($retData), MCRYPT_MODE_CBC, $encryption_iv));
        logmessages("txninit service response after decryption: " . $res);
        $decodedData = json_decode($res);
        $errorcd = "";
        if (property_exists($decodedData, "errorcd")) {
            $errorcd = $decodedData->errorcd;
        }
        if ($errorcd != NULL) {
            echo ("Server error ! Please contact your website Administrator! Error Code : " . $errorcd);
        } else {
            $trackid = $decodedData->trackid;  //ensure to save in db
            $txnstatus = $decodedData->txnstatus; //ensure to save in db
            $merchanttxnid = $decodedData->merchanttxnid;
            if ($trackid != NULL) {
                if ($txnstatus == "SUCCESS") {
                    $fval = array();
                    $fval["status"] = 1;
                    DB::table('online_transactions')->where('transaction_ref_id', $merchanttxnid)->update($fval);
                    $current = Carbon::now();
                    $ot = DB::table('online_transactions')->where('transaction_ref_id', $merchanttxnid)->first();
                    $ot = DB::table('online_transactions')->where('transaction_ref_id', $merchanttxnid)->first();
                    $data = array();
                    $data["payment_ref_no"] = $trackid;
                    $fval = array();
                    $fval["reservation_id"] = $ot->booking_id;
                    $fval["transaction_date"] =  $current;
                    $fval["amount"] =  $ot->amount;
                    $fval["mode_of_payment"] = 1;
                    $fval["payment_type"] =  1;
                    $fval["description"] = '-';
                    $fval["created_at"] = $current;
                    DB::table('transaction_details')->updateOrInsert($data, $fval);
                    $message = 'Greetings from LAICO, Your online transaction amount Rs.' . $ot->amount . " was success.Your Transaction Refrence No #" . $trackid;
                    Mail::to(auth()->user()->email)->queue(new SendStatus(auth()->user(), $message));
                    if (auth()->user()->country == 101) {
                        $message .= " Cheers,  Team Laico";
                        Helpers::sendsms(auth()->user()->mobile_no, $message);
                    }
                    return redirect(route('mybookings'))->with('status', "Your online transaction was success...");
                } else if ($txnstatus == "FAILURE") {
                    return redirect(route('mybookings'))->with('errormsg', "Your online transaction was Failed!");
                } else if ($txnstatus == "AWAITED") {
                    return redirect(route('mybookings'))->with('errormsg', "Txn status is awaited ! Please check after some time!.");
                }
            }
        }
    }



    
    public function partialamount($booking_id,Request $request)
    {
       
            return view('payment.partial')->with(['booking_id' =>$booking_id,'amount' => $request->amount ]);
       
    }




}
