<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class TextMeSMSService
{
    public function sendSms($to, $message)
    {
        // Access configuration values
        $apiKey = Config::get('services.textme.api_key');
        $senderNumber = Config::get('services.textme.from');

        // Implement the API call to TextMe here
        try {
            // Example API call (replace with actual implementation)
            // $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])
            //     ->post('https://api.textme.com/send', [
            //         'to' => $to,
            //         'from' => $senderNumber,
            //         'message' => $message,
            //     ]);

            // Log::info("TextMe SMS sent: " . $response->body());
            return true; // Return true if the message was sent successfully
        } catch (\Exception $e) {
            Log::error("TextMe SMS failed: " . $e->getMessage());
            return false; // Return false if the message failed
        }
    }
}
