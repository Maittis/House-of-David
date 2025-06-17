<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SMSWebhookController extends Controller
{
    public function receiveSMS(Request $request)
    {
        // Log incoming data (for debugging)
        Log::info('Incoming SMS:', $request->all());

        // Determine provider based on request
        $provider = $this->detectProvider($request);

        // Get phone and message based on provider format
        $phone = $this->getPhoneFromRequest($request, $provider);
        $message = $this->getMessageFromRequest($request, $provider);

        // Find member by phone number
        $member = Member::where('phone', $phone)->first();

        // Store in database
        DB::table('sms_replies')->insert([
            'member_id' => $member ? $member->id : null,
            'reply_message' => $message,
            'provider' => $provider,
            'created_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }

    protected function detectProvider(Request $request)
    {
        // Check request characteristics to determine provider
        if ($request->has('AccountSid')) {
            return 'twilio';
        } elseif ($request->has('textme_id')) {
            return 'textme';
        } elseif ($request->has('pingme_ref')) {
            return 'pingme';
        } elseif ($request->has('whatsapp_id')) {
            return 'whatsapp';
        }
        return 'unknown';
    }

    protected function getPhoneFromRequest(Request $request, $provider)
    {
        switch ($provider) {
            case 'twilio':
                return $request->input('From');
            case 'textme':
                return $request->input('sender');
            case 'pingme':
                return $request->input('originator');
            default:
                return $request->input('from');
        }
    }

    protected function getMessageFromRequest(Request $request, $provider)
    {
        switch ($provider) {
            case 'twilio':
                return $request->input('Body');
            case 'textme':
                return $request->input('text');
            case 'pingme':
                return $request->input('content');
            default:
                return $request->input('message');
        }
    }
}
