<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SMSWebhookController extends Controller
{
    public function receiveSMS(Request $request)
    {
        // Log incoming data (for debugging)
        Log::info('Incoming SMS:', $request->all());

        // Example incoming data (depends on provider)
        $phone = $request->input('from'); // Sender's phone number
        $message = $request->input('message'); // Reply message

        // Store in database (optional)
        DB::table('sms_replies')->insert([
            'phone' => $phone,
            'message' => $message,
            'created_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }
}
