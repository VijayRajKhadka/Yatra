<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Env;

class NotificationController extends Controller
{
    public function notify($title, $body,)
    {
        $url = "https://fcm.googleapis.com/fcm/send";

        $serverKey = 'AAAAqZsncns:APA91bEtEYALvbocWxbrExl1LJ9NxcvbxzwZCXNDnPg-WTAGelQYSGsYqCH3X2QWYbhnXAT_q0einPhzqy59kdTWJ_5qu-QMjyiJp1BUeQKIu08XjPMDvwB-DTZVSHil1u1B6dgH-YUG';
        //$serverKey =  env('NOTIFICATION_KEY','sync');
        $device_key='cK6nkjTJTt2GJXUKSG0jsC:APA91bHYOWA7-3etiQvtvrh9A70btL9JpblrmGgeivLmGL9xSVVtVr4IlpV-SNkjfUYrWezAd3qMtLDd6di5Y47d35R4is-umf_GLzXbkQlVc2b_CsSK66eIXELr4hjmht9_5JQR-_lI';
        
        $dataArr = [
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "status" => "done"
        ];

        $data = [
            "to" => $device_key,
            "notification" => [
                "body" => $body,
                "title" => $title,
            ],
            "data" => $dataArr,
            "priority" => "high"
        ];

        $encodedData = json_encode($data);

        $header = [
            "Authorization: key=" . $serverKey,
            "Content-Type: application/json",
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        $result = curl_exec($ch);

        if ($result === FALSE) {
            return [
                'success' => false,
                'message' => 'Failed to send notification',
                'error' => curl_error($ch) 
            ];
        } 

        curl_close($ch);
        return redirect()->back()->with('success', 'Notification sent successfully');

        }

        
    

    public function notifyapp(Request $request)
    {   
        $title = $request->input('title');
        $body = $request->input('body');

        return $this->notify($request->title, $request->body,);
    }
}

