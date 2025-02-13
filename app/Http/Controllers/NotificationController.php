<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
     public function sendSMS($phoneNumber, $message)
    {
        $recipient = "260976652858@airtel-sms.com"; // Use the correct gateway
        Mail::raw('Hello Church Member!', function ($message) use ($recipient) {
            $message->to($recipient)
                    ->subject('SMS Notification');
        });

        return "SMS Sent to $phoneNumber!";
    }
}
