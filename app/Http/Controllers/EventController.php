<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_datetime', 'desc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        $slug = Str::slug($data['title']);
        $count = Event::where('slug', 'LIKE', "{$slug}%")->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('event_images', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_datetime' => 'required|date',
            'end_datetime' => 'nullable|date|after_or_equal:start_datetime',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        $slug = Str::slug($data['title']);
        $count = Event::where('slug', 'LIKE', "{$slug}%")->where('id', '!=', $event->id)->count();
        $data['slug'] = $count ? "{$slug}-{$count}" : $slug;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('event_images', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        return view('events.show', compact('event'));
    }
}
