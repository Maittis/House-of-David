<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inquiry;

class MemberDashboardController extends Controller
{
    /**
     * Show the member dashboard with attendance feature.
     */
    public function memberDashboard()
    {
        // Load inquiries for the authenticated member
        $inquiries = Inquiry::where('user_id', auth()->id())->get();

        return view('memberArea.dboard', compact('inquiries'));
    }

    /**
     * Existing method memberInquiries (if any) can be adjusted here if needed.
     */
    public function memberInquiries()
    {
        // Implementation of existing method if needed
    }
}
