<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    /**
     * Show the form for editing the hero section.
     */
    public function index()
    {
        $heroSection = HeroSection::first();
        return view('admin.hero_section.index', compact('heroSection'));
    }

    /**
     * Update the hero section image.
     */
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120', // max 5MB
        ]);

        $heroSection = HeroSection::first();

        if ($request->hasFile('image')) {
            // Delete old image if exists and not default
            if ($heroSection && $heroSection->image_path && $heroSection->image_path !== 'images/built.jpg') {
                Storage::disk('public')->delete($heroSection->image_path);
            }

            $path = $request->file('image')->store('hero_images', 'public');

            if (!$heroSection) {
                $heroSection = new HeroSection();
            }

            $heroSection->image_path = $path;
            $heroSection->save();
        }

        return redirect()->back()->with('success', 'Hero image updated successfully.');
    }
}
