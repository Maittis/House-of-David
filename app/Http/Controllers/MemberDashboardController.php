<?php

namespace App\Http\Controllers; // Assuming this is where your controller resides

use App\Models\Video;
use App\Models\Comment;
use App\Models\InspirationalMessage;
use App\Models\Inquiry;

class MemberDashboardController extends Controller
{
    public function index()
    {
         // Fetch the latest 5 inspirational messages
    $inspirationalMessages = InspirationalMessage::latest()->take(5)->get();
    $userId = auth()->id();
    $inquiries = Inquiry::where('user_id', $userId)->latest()->get();
        // Fetch latest videos, messages, etc.
        $videos = Video::latest()->paginate(10);
        $messages = InspirationalMessage::latest()->paginate(5);
        return view('memberArea.dboard', compact(


            'videos', 'messages',
            'inquiries',

        ));
    }

    public function watchVideo($id)
    {
        $video = Video::findOrFail($id);
        $comments = Comment::where('video_id', $id)->latest()->paginate(10);
        return view('memberArea.video', compact('video', 'comments'));
    }







    // Add more methods here for other functionalities as needed
}
