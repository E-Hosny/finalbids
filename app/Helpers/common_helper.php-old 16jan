<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


function current_location($ip,$lat,$long)
    {
        $currentUserInfo = Location::get($ip);
        // p($currentUserInfo);
        if(isset($currentUserInfo->latitude) && isset($currentUserInfo->longitude) && !empty($lat) && !empty($long)){
           return distance($currentUserInfo->latitude, $currentUserInfo->longitude,$lat,$long,"K");
       }
    }


function p($p,$exit = 1)
{
	echo '<pre>';
	print_r($p);
	echo '</pre>';
	if($exit == 1)
	{
		exit;
	}
}

function isEmail($email) {
    $find1 = strpos($email, '@');
    $find2 = strpos($email, '.');
    return ($find1 !== false && $find2 !== false && $find2 > $find1);
}

//send otp function
function sendOtp($msg, $mobile, $countryCode)
{
    $AccountSid   =  "AC2a3b01d00d1d6778cd3f0a02b646e11e";
    $AuthToken    = "55f2d9992b0b6a043e0c5545ccee3c3b";
    
    // Create a configuration array
    $config = [
        'auth' => [$AccountSid, $AuthToken],
    ];
    
    $client = new Client($config);
    $contact = $countryCode . $mobile;
    
    try {
        DB::beginTransaction();
        $client->post('https://api.twilio.com/2010-04-01/Accounts/' . $AccountSid . '/Messages.json', [
            'auth' => [$AccountSid, $AuthToken],
            'form_params' => [
                'To' => $contact,
                'From' => "+17853902515",
                'Body' => $msg,
            ],
        ]);
        
        DB::commit(); // Commit the database transaction
        
        $response = [
            'message' => 'success',
            'status' => 1,
        ];
        
        return $response;
    } catch (Exception $e) {
        DB::rollback(); // Rollback the database transaction in case of an exception
        
        $response = [
            'message' => $e->getMessage(),
            'status' => 0,
        ];
        
        return $response;
    }

    // $AccountSid   =  "AC2a3b01d00d1d6778cd3f0a02b646e11e";
    // $AuthToken    = "55f2d9992b0b6a043e0c5545ccee3c3b";
    // $client       =  new Client($AccountSid, $AuthToken);
    // $contact      =  $countryCode . $mobile;
    // try {
    //     DB::beginTransaction();
    //     $client->account->messages->create(
    //         $contact,
    //         array(
    //             'from' => "+17853902515",
    //             'body' => $msg
    //         )
    //     );
    //     // print_r($sms);die;
    //     $response     =  [
    //         'message' => 'success',
    //         'status'  => 1,
    //     ];
    //     return $response;
    // } catch (Exception $e) {
    //     $response = [
    //         'message' => $e->getMessage(),
    //         'status'  => 0,
    //     ];
    //     return $response;
    // }
}






//send otp function
function send_otp1($mobile){
    $otpnum = rand(1111, 9999);
    $curl = curl_init();

      curl_setopt_array($curl, array(
      CURLOPT_URL => "http://2factor.in/API/V1/3565904e-cc65-11ed-81b6-0200cd936042/SMS/".$mobile."/".$otpnum."/Cityroom%20OTP",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      return 2;
    } else {
       $response;
    }

    $otp_user = UserOtp::where('mobile',$mobile)->first();
    if (!empty($otp_user)) {
        $userotp = UserOtp::find($otp_user->id);
    }else{
        $userotp = new UserOtp;
    }

    $userotp->mobile        = $mobile;
    $userotp->otp           = $otpnum;
    $userotp->save();

    return 1;
}

/**
     *  Check file exist or not
     * */
    function check_file_exist($file_name, $custome_key,$thumbnail = false, $default_img = false)
    {
        $return_file        = '';
        $config_upload_path = \Config::get('custom.' . $custome_key);
        if($thumbnail == true)
        {
          $path = $config_upload_path['thumb_display_path'];   
        }
        else
        {
         $path =  $config_upload_path['display_path'];     
        }
        if (!empty($file_name))
        {
            if (is_file($path. $file_name))
            {
                $return_file = url($path.$file_name);
            }
            else
            {
             $return_file = url('public/default-image/default.png');   
            }
        }
        return $return_file;
    }



    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
      if (($lat1 == $lat2) && ($lon1 == $lon2)  && (empty($lon1) || empty($lon2))) {
        return 0;
      }
      else {
        $theta = $lon1-$lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
          return number_format(($miles * 1.609344),2);
        } else if ($unit == "N") {
          return ($miles * 0.8684);
        } else {
          return $miles;
        }
      }
    }


    //Send Firebase Notification to User using App
    function apiNotificationForApp($token, $title, $type = null, $description = null){
    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $fcmNotification = [
            "to" => $token,
            "notification" => [
                "title"      => $title,
                "body"       => $description,
                "type"       => $type
            ],
            'data' => [
                "extra_data" => 'asd',
                 "title"      => $title,
                "body"       => $description,
                "type"       => $type
                
            ]
        ];   

    $headers = [
        'Authorization:key=AAAAEJWfzEY:APA91bHGvUbkMX_eDFGYPyrNRqIkg0CXc7WOKz8xTvTe-zet2-5zovFhz1GSp94PrqBBG7AKpYT7uQOow6rPvdAuPVMZhYD3y43vLu90jHcAPigaUyDFQVIrU8xQqLXCWMl6mJTCLcsI',
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    // p($result);
    curl_close($ch);
    return true;
}

    
    
?>