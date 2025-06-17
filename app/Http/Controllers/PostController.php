<?php


    namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create', ['post_types' => ['event', 'sermon', 'testimony']]);
    }

        public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image_path = $imagePath;
        }

        $post->save();

        return redirect()->route('posts.index')
                        ->with('success', 'Post created successfully.');
    }



        public function show(Post $post)
        {
            return view('posts.show', compact('post'));
        }

        public function edit(Post $post)
        {
            return view('posts.edit', compact('post'));
        }


    public function update(Request $request, Post $post)
{
    $request->validate([
        'title' => 'required',
        'content' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Store the current image path before updating, to handle deletion if necessary
    $oldImagePath = $post->image_path;

    // Update post data
    $post->update([
        'title' => $request->title,
        'content' => $request->content,
    ]);

    // Handle image upload if a new image is provided
    if ($request->hasFile('image')) {
        // If there was an old image, delete it
        if ($oldImagePath && file_exists(storage_path('app/public/' . $oldImagePath))) {
            unlink(storage_path('app/public/' . $oldImagePath));
        }

        // Store new image
        $imageName = time() . '.' . $request->image->extension();
        $newImagePath = $request->file('image')->storeAs('post_images', $imageName, 'public');
        $post->update(['image_path' => $newImagePath]);
    }

    return redirect()->route('posts.index')
                     ->with('success', 'Post updated successfully');
}


    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
                         ->with('success', 'Post deleted successfully');
    }
}

