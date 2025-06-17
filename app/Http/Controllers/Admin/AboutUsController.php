<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function edit()
    {
        $about = AboutUs::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $about = AboutUs::first();
        if (!$about) {
            $about = new AboutUs();
        }
        $about->content = $request->input('content');
        $about->save();

        return redirect()->route('admin.about.edit')->with('success', 'About Us content updated successfully.');
    }

    public function show()
    {
        $about = AboutUs::first();
        return view('about', compact('about'));
    }
}
