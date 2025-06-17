<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_image' => 'nullable|image|max:5120',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string',
        ]);

        $testimonial = new Testimonial();
        $testimonial->author_name = $request->author_name;
        $testimonial->rating = $request->rating;
        $testimonial->text = $request->text;

        if ($request->hasFile('author_image')) {
            $path = $request->file('author_image')->store('testimonial_images', 'public');
            $testimonial->author_image = $path;
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'author_image' => 'nullable|image|max:5120',
            'rating' => 'required|integer|min:1|max:5',
            'text' => 'required|string',
        ]);

        $testimonial->author_name = $request->author_name;
        $testimonial->rating = $request->rating;
        $testimonial->text = $request->text;

        if ($request->hasFile('author_image')) {
            if ($testimonial->author_image) {
                Storage::disk('public')->delete($testimonial->author_image);
            }
            $path = $request->file('author_image')->store('testimonial_images', 'public');
            $testimonial->author_image = $path;
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->author_image) {
            Storage::disk('public')->delete($testimonial->author_image);
        }
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted successfully.');
    }
}
