<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Show contact form (GET)
    public function create()
    {
        return view('contact');
    }

    // Store contact message (POST)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
