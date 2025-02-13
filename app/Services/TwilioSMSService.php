<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class TwilioSMSService
{
    public function twiliosendSms($to, $message)
    {
        // Access configuration values
        $sid = Config::get('services.twilio.sid');
        $token = Config::get('services.twilio.token');
        $senderNumber = Config::get('services.twilio.from');

        $twilio = new Client($sid, $token);

        try {
            $twilio->messages->create(
                $to, // Use the recipient number passed to the function
                [
                    "from" => $senderNumber,
                    "body" => $message
                ]
            );

            return true; // Return true if the message was sent successfully
        } catch (\Exception $e) {
            Log::error("Twilio SMS failed: " . $e->getMessage());
            return false; // Return false if the message failed
        }
    }
}
