<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class WelcomeController extends Controller

{
    public function index()
    {
        $posts = Post::latest()->take(3)->get(); // Fetch the latest 3 posts
        return view('welcome', compact('posts'));
    }
}




