<?php

namespace App\Http\Controllers;

use App\Models\OrderOfWorship;
use Illuminate\Http\Request;

class OrderOfWorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = OrderOfWorship::orderBy('created_at', 'desc')->get();
        return view('admin.order_of_worship.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.order_of_worship.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:order_of_worship,pastor_devotion',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
        ]);

        $data = $request->only('title', 'type', 'content', 'video_url');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('order_of_worship_images', 'public');
            $data['image_path'] = $path;
        }

        OrderOfWorship::create($data);

        return redirect()->route('admin.order_of_worship.index')->with('success', 'Content created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderOfWorship $orderOfWorship)
    {
        return view('admin.order_of_worship.edit', compact('orderOfWorship'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderOfWorship $orderOfWorship)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:order_of_worship,pastor_devotion',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|url',
        ]);

        $data = $request->only('title', 'type', 'content', 'video_url');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('order_of_worship_images', 'public');
            $data['image_path'] = $path;
        }

        $orderOfWorship->update($data);

        return redirect()->route('admin.order_of_worship.index')->with('success', 'Content updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderOfWorship $orderOfWorship)
    {
        $orderOfWorship->delete();

        return redirect()->route('admin.order_of_worship.index')->with('success', 'Content deleted successfully.');
    }
}
