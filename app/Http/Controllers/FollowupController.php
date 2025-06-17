<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Followup; // Assuming a Followup model exists or will be created

class FollowupController extends Controller
{
    /**
     * Display a listing of follow-up replies.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $replies = Followup::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.followup.index', compact('replies'));
    }

    /**
     * Show the form for creating a new follow-up reply.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.followup.create');
    }

    /**
     * Store a newly created follow-up reply in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'recipient' => 'required|string|max:255',
        ]);

        Followup::create($request->all());

        return redirect()->route('admin.followup.index')->with('success', 'Follow-up reply created successfully.');
    }

    /**
     * Show the form for editing the specified follow-up reply.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\View\View
     */
    public function edit(Followup $followup)
    {
        return view('admin.followup.edit', compact('followup'));
    }

    /**
     * Update the specified follow-up reply in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Followup $followup)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'recipient' => 'required|string|max:255',
        ]);

        $followup->update($request->all());

        return redirect()->route('admin.followup.index')->with('success', 'Follow-up reply updated successfully.');
    }

    /**
     * Remove the specified follow-up reply from storage.
     *
     * @param  \App\Models\Followup  $followup
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Followup $followup)
    {
        $followup->delete();

        return redirect()->route('admin.followup.index')->with('success', 'Follow-up reply deleted successfully.');
    }

    /**
     * Send a follow-up reply.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send($id)
    {
        $followup = Followup::findOrFail($id);

        // Implement sending logic here, e.g., SMS, email, etc.
        // For now, just simulate sending.

        // Example: SMSService::send($followup->recipient, $followup->message);

        return redirect()->route('admin.followup.index')->with('success', 'Follow-up reply sent successfully.');
    }
}
