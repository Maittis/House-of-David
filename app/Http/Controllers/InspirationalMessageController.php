<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InspirationalMessage;

class InspirationalMessageController extends Controller
{


    public function index()
    {
        $inspirationalMessages = InspirationalMessage::latest()->get();

        return view('admin.inspirational_messages', compact('inspirationalMessages'));
    }


    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Save the new message
        InspirationalMessage::create([
            'content' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }

    public function getLatestInspiration()
    {
        $message = InspirationalMessage::latest()->first();
        return response()->json([
            'content' => $message->content ?? 'No messages yet',
            'date' => $message ? $message->created_at->format('Y-m-d') : ''
        ]);
    }

}
