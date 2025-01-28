<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
class TwilioSMSService
{
    protected $twilio;

    public function __construct()
    {
        // Properly fetch Twilio credentials from the environment
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');

    }



public function sendSMS(array $recipients, string $message)
{
    foreach ($recipients as $recipient) {
        try {
            $response = $this->twilio->messages->create(
                $recipient,
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => $message,
                ]
            );
            Log::info("SMS sent successfully to {$recipient}. SID: " . $response->sid);
        } catch (\Exception $e) {
            Log::error("Failed to send SMS to {$recipient}: " . $e->getMessage());
        }
    }
}
}
