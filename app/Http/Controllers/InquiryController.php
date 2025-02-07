<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the input
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Process the inquiry (store in DB, send email, etc.)
        // Example: Saving to database
        DB::table('inquiries')->insert([
            'message' => $request->message,
            'created_at' => now(),
        ]);

        // Redirect with success message
        return back()->with('success', 'Inquiry submitted successfully!');
    }
}
