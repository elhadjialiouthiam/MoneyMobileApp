<?php
namespace App\Services;
use Twilio\Rest\Client;
class SendSms{
    public function send(){
            // Your Account SID and Auth Token from twilio.com/console
    $account_sid = 'AC0a1b126ed02125876e1794aa53778642';
    $auth_token = 'ceabc5e6a5cf0adda3289e8beba7e1cb';
    // In production, these should be environment variables. E.g.:
    // $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

    // A Twilio number you own with SMS capabilities
    $twilio_number = "(832) 529-6840";

    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
        // Where to send a text message (your cell phone?)
        '+221775466284',
        array(
            'from' => $twilio_number,
            'body' => 'I sent this message in under 10 minutes!'
        )
    );

        }
}
