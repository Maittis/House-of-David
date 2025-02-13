<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Log;

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


    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();

        return redirect()->route('admin.inquiries')
                         ->with('success', 'Inquiry has been deleted successfully.');
    }



    public function storeReply(Request $request, Inquiry $inquiry)
    {
        if (!$inquiry) {
            return back()->with('error', 'Inquiry not found.');
        }

        $request->validate([
            'reply' => 'required|string',
        ]);

        try {
            $inquiry->reply()->create([
                'reply' => $request->input('reply'),
            ]);
            return back()->with('success', 'Reply sent successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to store reply: " . $e->getMessage());
            return back()->with('error', 'Failed to store reply. Please try again.');
        }
    }


}

