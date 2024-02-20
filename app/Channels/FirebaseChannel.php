<?php


namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class FirebaseChannel
{
    public function send($notifiable, Notification $notification)
    {
        $url = env('FIREBASE_URL');
        $FcmToken = $notification->fcmToken;
        $FcmToken = [$FcmToken];


        // if (!$notifiable->is_push_notification_enabled) return;

        if (empty($FcmToken)) {
            Log::error('Device ID not exist for push notification!: User ID: ' . $notifiable->id);
            throw new \Exception('Device ID not exist for push notification!');
        }

        $serverKey = env('FIREBASE_SERVER_KEY');



        $data = [
            "registration_ids" => $FcmToken,
            "priority" => "high",
            "contentAvailable" => true,
            'notification' => [
                "title" => $notification->title,
                "body" => $notification->message,
                "sound" => "my_sound.wav",
                "android_channel_id" => "tacsi-app"
            ]
        ];

        if (!is_null($notification->data)) {
            $data['data'] = $notification->data;
        }
        $encodedData = json_encode($data);


        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);



        if ($result === FALSE) {
            Log::error('Curl failed: ' . curl_error($ch), ['push_token' => $notification->fcmToken]);
            throw new \Exception('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
        $result = json_decode($result, true);
        if (!isset($result['success']) || $result['success'] != 1) {
            Log::error('Curl failed: ' . json_encode($result), ['push_token' => $notification->fcmToken]);
        } else {
            Log::info('Notification sent', ['push_token' => $notification->fcmToken]);
        }
    }
}