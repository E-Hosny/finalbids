<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    function apiNotificationForApp($token, $title, $sound = null, $description = null,$rem_id = null,$type = null){
      
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
            $fcmNotification = [
                "to" => $token,
                "notification" => [
                    "title"      => $title,
                    "body"       => $description,
                    "type"       => $type,
                    "rem_id"       => $rem_id,
                    "sound"       => $sound,
                ],
                'data' => [
                    "click_action" => "ACTION_CATEGORY",
                ]
            ];   
    
        $headers = [
            'Authorization:key=AAAAG902cEI:APA91bEFbLf9a6eXm5OJfjjCafEio3adu4uEK1eNpvdOB_EjFk9n2SFP97luWbJMumHbInFKB7Xm0cJgwnup_S5g2__ULr4azGHBf6E7D8tVqnwtCNyPeXTEOlMBUEveXkhNJHuNESL_',
            'Content-Type: application/json'
        ];

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        // print_r($result);
        // die();
        curl_close($ch);
        return true;
    }
}
