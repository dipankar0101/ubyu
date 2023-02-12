<?php

namespace App\Http\Controllers;

use Validator;
use DB;
use Hash;
use Auth;

class SmsController extends Controller
{

    /*************** send sms *****************/
    public function sendSms($mob_no,$msg,$template_id){

        $sms_uname = env('SMS_UNAME','AgSuga');
        $sms_pwd = env('SMS_PWD','sMS@123');
        $sms_senderid = env('SMS_SENDERID','AgSuga'); //Header
        $sms_route = env('SMS_ROUTE','T');
        $sms_peid = env('SMS_PEID','1701165661441255136'); //EntityID 

        // $mobile_no = "8348515535";
        // $message = 'Hello world!.';
        $mobile_no = $mob_no;
        $message = $msg;

        if(!empty($mobile_no)){
            try {
                $URL = "http://smsapi.amrithaa.com/sendsms?uname=".$sms_uname."&pwd=".$sms_pwd."&senderid=".$sms_senderid."&to=".urlencode($mobile_no)."&msg=".urlencode($message)."&route=".$sms_route."&peid=".$sms_peid."&tempid=".$template_id."";

                $ch = curl_init();                       // initialize CURL
                curl_setopt($ch, CURLOPT_POST, false);    // Set CURL Post Data
                curl_setopt($ch, CURLOPT_URL, $URL);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);

            } catch (\Exception $e) {
                // echo $e;exit;
                // return view('errors.not_install');
            }
        }                         // Close CURL

        // Use file get contents when CURL is not installed on server.
        // if(!$output){
        //    $output =  file_get_contents($URL);  
        // }
        // return $output;

        return 1;

    }
    /*************** send sms *****************/



}