<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a paginated listing of blog posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch posts paginated, 10 per page
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('blog', compact('posts'));
    }

    /**
     * Display a single blog post.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('blog.show', compact('post'));
    }
}
