<?php

namespace App\Http\Controllers;

use App\Models\Sermon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SermonController extends Controller
{
    public function index()
    {
        $sermons = Sermon::latest()->paginate(10);
        return view('admin.sermons.index', compact('sermons'));
    }

    public function create()
    {
        return view('admin.sermons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);

        Sermon::create($data);

        return redirect()->route('admin.sermons.index')->with('success', 'Sermon created successfully.');
    }

    public function edit(Sermon $sermon)
    {
        return view('admin.sermons.edit', compact('sermon'));
    }

    public function update(Request $request, Sermon $sermon)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($data['title']);

        $sermon->update($data);

        return redirect()->route('admin.sermons.index')->with('success', 'Sermon updated successfully.');
    }

    public function destroy(Sermon $sermon)
    {
        $sermon->delete();
        return redirect()->route('admin.sermons.index')->with('success', 'Sermon deleted successfully.');
    }

    // Public methods for sermons

    public function publicIndex()
    {
        $sermons = Sermon::latest()->paginate(10);
        return view('sermons.index', compact('sermons'));
    }

    public function publicShow(Sermon $sermon)
    {
        return view('sermons.show', compact('sermon'));
    }
}
