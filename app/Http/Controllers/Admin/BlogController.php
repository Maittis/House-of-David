<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => 'nullable|in:event,sermon,testimony',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image_path'] = $path;
        }

        Post::create($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(Post $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Post $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'post_type' => 'nullable|in:event,sermon,testimony',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($blog->image_path) {
                Storage::disk('public')->delete($blog->image_path);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validated['image_path'] = $path;
        }

        $blog->update($validated);

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Post $blog)
    {
        if ($blog->image_path) {
            Storage::disk('public')->delete($blog->image_path);
        }
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
