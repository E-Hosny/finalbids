<?php
namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;
// use Twilio\Http\Client;
use Twilio\Rest\Client;



class OtpController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendOtp(Request $request)
    {
        $otp = random_int(100000, 999999);

        $phoneNumber = $request->input('phone');

        $message = "Your OTP code is: " . $otp;

        $this->twilioService->sendSms($phoneNumber, $message);

        return response()->json(['message' => 'OTP has been sent to your phone']);
    }




    public function test(){
        $r="+966542327025";
        $m="1234";

        try{
            $ac_sid=getenv("TWILIO_SID");
            $auth_token=getenv("TWILIO_AUTH_TOKEN");
            $t_num=getenv("TWILIO_PHONE_NUMBER");

            $client=new Client($ac_sid,$auth_token);
            $client->messages->create($r,[
                'from' => $t_num,
                'body' => $m
            ]);
            dd("message sent succefully");

    } catch (Exception $e){
        dd("error : ". $e->getMessage());
    }
}

}

