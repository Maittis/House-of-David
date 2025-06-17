<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->route('admin.contacts.index')->with('success', 'Contact created successfully.');
    }

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function reply(\Illuminate\Http\Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'reply_message' => 'required|string',
        ]);

        \Mail::raw($validated['reply_message'], function ($message) use ($contact) {
            $message->to($contact->email)
                ->subject('Reply to your contact inquiry');
        });

        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Reply sent successfully.');
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $contact->update($validated);

        return redirect()->route('admin.contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')->with('success', 'Contact deleted successfully.');
    }
}
