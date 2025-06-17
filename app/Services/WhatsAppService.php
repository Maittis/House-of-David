<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->token = config('services.whatsapp.token');
    }

    /**
     * Send a WhatsApp message using the WhatsApp API.
     *
     * @param string $to Recipient phone number in international format
     * @param string $message Message text
     * @return bool True if sent successfully, false otherwise
     */
    public function sendMessage(string $to, string $message): bool
    {
        try {
            $response = Http::withToken($this->token)
                ->post($this->apiUrl . '/messages', [
                    'to' => $to,
                    'type' => 'text',
                    'text' => [
                        'body' => $message,
                    ],
                ]);

            if ($response->successful()) {
                return true;
            } else {
                Log::error('WhatsApp API error: ' . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp API exception: ' . $e->getMessage());
            return false;
        }
    }
}
