<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    public function sendSms($contactNumber,$message)
    {
        $client = new Client();
        $url = 'https://dkppl1.api.infobip.com/sms/2/text/advanced';

        $headers = [
            'Authorization' => 'App 85febc947deecbe31ac6637535c26054-1c4674fd-5edb-4d57-ba25-e338bc637f84',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $body = json_encode([
            "messages" => [
                [
                    "destinations" => [
                        ["to" => $contactNumber]
                    ],
                    "from" => "SL Railway",
                    "text" => $message
                ]
            ]
        ]);

        try {
            $response = $client->post($url, [
                'headers' => $headers,
                'body' => $body
            ]);

            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'SMS sent successfully!']);
            } else {
                Log::error('Failed to send SMS: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase());
                return response()->json(['error' => 'Failed to send SMS.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            return response()->json(['error' => 'Error sending SMS.'], 500);
        }
    }
}