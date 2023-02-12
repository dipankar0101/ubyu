<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiController extends Controller
{
    /********************* user sign up **********************/
    public function signUp(Request $request)
    {
        $result = array();
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone'   => 'required',
                'email' => 'required',
                'password'   => 'required',
            ]
        );
        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = "Please enter all credentials.";
            $result['error'] = $validator->messages();
            return $result;
        }
        $input = $request->all();

        $user_email = array();
        if ($request->email) {
            $user_email = DB::table('users')
                ->select('email')
                ->where('email', $input['email'])
                ->where('role_id','=', 2)
                ->where('social_id','=', null)
                ->get();
        }
        
        $user_phone = DB::table('users')
            ->select('phone')
            ->where('phone', $input['phone'])
            ->where('role_id','=', 2)
            ->where('social_id','=', null)
            ->get();

        if (count($user_email) > 0) {
            $result['status'] = false;
            $result['message'] = "Email already exist";
            $result['error'] = "";
        }else if (count($user_phone) > 0) {
            $result['status'] = false;
            $result['message'] = "Phone no already exist";
            $result['error'] = "";
        } else {
            $rand_otp = mt_rand(1000,9999);
            // $rand_otp = 1234;

            $signUpData = array(
                'name'        => $input['name'],
                'email'       => $input['email'],
                'phone'       => $input['phone'],
                'password'    => $input['password'],
                'otp'         => $rand_otp
            );

            /************/
            //Your OTP verification code for ubyu.Ag app is {#var#}. Please do not share with anyone.


            $msg = 'Your OTP verification code for ubyu.Ag app is '.$rand_otp.'. Please do not share with anyone.';
            $template_id = '1707166092128116962';
            $mySms = new SmsController();
            $mySms->sendSms($input['phone'],$msg,$template_id);
            /************/

            $result['status'] = true;
            $result['message'] = "Signup otp send successfully.";
            $result['signUpData'] = $signUpData;
            $result['error'] = "";
        }

        return $result;
    }

    public function processSignup(Request $request)
    {
        $result = array();
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone'   => 'required',
                'password'   => 'required',
                'device_id'   => 'required',
                'os_type'   => 'required',
            ]
        );
        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = "Please enter all credentials.";
            $result['error'] = $validator->messages();
            return $result;
        }
        $input = $request->all();

        $date = date('y-m-d H:i:s');
        $newUser_id = DB::table('users')->insertGetId([
            'name'      =>  $input['name'],
            'phone'     =>  $input['phone'],
            'email'     =>  $input['email'],
            'role_id'   =>  2,
            'device_id'     =>  $input['device_id'],
            'os_type'     =>  $input['os_type'],
            'password'  =>  Hash::make($input['password']),
            'created_at'=>  $date
        ]);
        if ($newUser_id) {
            $user_details = DB::table('users')
                ->where('id', $newUser_id)
                ->get();
            $result['status'] = true;
            $result['message'] = "Signup successfully.";
            $result['userDetails'] = $user_details;
            $result['error'] = "";
        }else{
            $result['status'] = false;
            $result['message'] = "Something went wrong. Please try again!";
            $result['error'] = "Something went wrong. Please try again!";
        }

        return $result;
    }
    /********************* user sign up **********************/

    /********************* user login **********************/
    function login(Request $request)
    {
        $result = array();
        $validator = Validator::make(
            $request->all(),
            [
                'emailPhone' => 'required',
                'password'   => 'required',
                'device_id'   => 'required',
                'os_type'   => 'required',
            ]
        );
        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = "Please enter all credentials.";
            $result['error'] = $validator->messages();
            return $result;
        }
        $user= User::where('email', $request->emailPhone)->orWhere('phone', $request->emailPhone)->first();
        if (!$user){
            $result['status'] = false;
            $result['message'] = "Please enter valid user name";
            return $result;
        }elseif(!Hash::check($request->password, $user->password)){
            $result['status'] = false;
            $result['message'] = "Please enter valid password";
            return $result;
        }else{
            $user_id= $user->id;
            DB::table('users')->where('id', $user_id)->update([
                'device_id' => $request->device_id,
                'os_type' => $request->os_type,
            ]);
            if ($user->customer_image != '') {
                $user->customer_image = url($user->customer_image);
            }else{
                $user->customer_image = url('images/user.png');
            }
            $user->device_id = $request->device_id;
            $user->os_type = $request->os_type;

            $token = $user->createToken('my-app-token')->plainTextToken;
            $result['status'] = true;
            $result['message'] = "Valid user";
            $result['token'] = $token;
            $result['userDetails'] = $user;
        }

        return $result;
    }
    /********************* user login **********************/

    /********************* Forget Password **********************/
    public function forgetPassword(Request $request)
    {

        $result = array();
        $validator = Validator::make(
            $request->all(),
            [
               'email_phone' => 'required',
            ]
        );
        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = "Please enter all credentials.";
            $result['error'] = $validator->messages();
            return $result;
        }
        $email_phone = $request->email_phone;
        $userExist = DB::table('users')
            ->select('users.*')
            ->where('phone','=', $email_phone)
            // ->orWhere('email','=', $email_phone)
            ->where('role_id','=', 2)
            ->where('social_id','=', null)
            ->get();
            
        if ($userExist->isEmpty()) {
            $result['status'] = false;
            $result['message'] = 'User does not exist.';
            $result['error'] = "";
        } else {
            $rand_otp = mt_rand(1000,9999);
            // $rand_otp = 1234;
            // $userExist[0]->otp_check = $rand_otp;

            /************/
            $msg = 'Your OTP verification code for ubyu.Ag app is '.$rand_otp.'. Please do not share with anyone.';
            $template_id = '1707166092128116962';
            $mySms = new SmsController();
            $mySms->sendSms($email_phone,$msg,$template_id);
            /************/

            DB::table('users')->where('id', $userExist[0]->id)->update(['otp_check' => $rand_otp]);

            $result['status'] = true;
            $result['message'] = 'An otp has been sent to your email address.';
            $result['otp'] = $rand_otp;
            $result['userDetails'] = $userExist;
            $result['error'] = "";
        }

        return $result;

    }

    public function passwordOtpCheck(Request $request)
    {
        $result = array();
        $validator = Validator::make(
            $request->all(),
            [
               'user_id' => 'required',
               'otp' => 'required',
            ]
        );
        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = "Please enter all credentials.";
            $result['error'] = $validator->messages();
            return $result;
        }

        $user_id = $request['user_id'];
        $otp_check = $request['otp'];
        $existUser = DB::table('users')
            ->where('id', $user_id)
            ->where('otp_check', $otp_check)
            ->get();
        if (count($existUser) > 0) {
            $result['status'] = true;
            $result['message'] = "OTP match.";
            $result['userDetails'] = $existUser;
            $result['error'] = "";
        }else{
            $result['status'] = false;
            $result['message'] = "Wrong OTP.";
            $result['error'] = "";
        }
        return $result;
    }
    /********************* Forget Password **********************/

    /****************** update new password ******************/
    public function updateNewPassword(Request $request)
    {
        $result = array();
        $validator = Validator::make(
            $request->all(),
            [
               'user_id' => 'required',
               'new_password' => 'required',
               'confirm_password' => 'required',
            ]
        );
        if ($validator->fails()) {
            $result['status'] = false;
            $result['message'] = "Please enter all credentials.";
            $result['error'] = $validator->messages();
            return $result;
        }
        $user_id = $request['user_id'];
        $new_password = $request['new_password'];
        $confirm_password = $request['confirm_password'];
        if ($new_password!=$confirm_password) {
            $result['status'] = false;
            $result['message'] = "Password and confirm password does not match.";
            $result['error'] = "";
        }else{
            $hashPassword = Hash::make($new_password);
            DB::table('users')->where('id', $user_id)->update([
                'password' => $hashPassword,
            ]);

            $existUser = DB::table('users')
                ->where('id', $user_id)
                ->get();

            $result['status'] = true;
            $result['message'] = "Password updated successfully.";
            $result['userDetails'] = $existUser;
            $result['error'] = "";
        }
        return $result;
    }
    /****************** update new password ******************/

    public function checkLogin(Request $request){
        try {
            // run your code here
            return $request->user();
        }
        catch (exception $e) {
            //code to handle the exception
            return $e;
        }
        // finally {
        //     //optional code that always runs
        // }
    }
}