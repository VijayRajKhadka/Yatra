<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Env;
use App\Models\NotificationToken;

class NotificationController extends Controller
{
    public function notify($title, $body,)
    {
        $url = "https://fcm.googleapis.com/fcm/send";

        $serverKey = 'AAAAqZsncns:APA91bEtEYALvbocWxbrExl1LJ9NxcvbxzwZCXNDnPg-WTAGelQYSGsYqCH3X2QWYbhnXAT_q0einPhzqy59kdTWJ_5qu-QMjyiJp1BUeQKIu08XjPMDvwB-DTZVSHil1u1B6dgH-YUG';
        //$serverKey =  env('NOTIFICATION_KEY','sync');

        $deviceKeys = NotificationToken::distinct()->pluck('token')->toArray();

        $dataArr = [
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "status" => "done"
        ];

        $result=false;
        foreach ($deviceKeys as $deviceKey) {
        $data = [
            "to" => $deviceKey,
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

        curl_close($ch);

        }
        if ($result === FALSE) {
            return [
                'success' => false,
                'message' => 'Failed to send notification',
                'error' => curl_error($ch) 
            ];
        } 

        return redirect()->back()->with('success', 'Notification sent successfully');

    }

    public function notifyapp(Request $request)
    {   
        $title = $request->input('title');
        $body = $request->input('body');

        return $this->notify($request->title, $request->body,);
    }


    public function storetoken(Request $request){
        $token = $request->input('token');

        $notificationToken = new NotificationToken();
        $notificationToken->token = $token;
        $notificationToken->save();

        return response()->json(['success' => true, 'message' => 'Token stored successfully']);
    }
}

