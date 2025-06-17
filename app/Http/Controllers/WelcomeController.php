<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sermon;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $events = Event::whereDate('start_datetime', '>=', now()->toDateString())
                    ->orderBy('start_datetime', 'asc')
                    ->take(3)
                    ->get()
                    ->map(function ($event) {
                        $event->start_datetime = \Carbon\Carbon::parse($event->start_datetime);
                        $event->end_datetime = $event->end_datetime ? \Carbon\Carbon::parse($event->end_datetime) : null;
                        return $event;
                    });

        $sermons = Sermon::latest()
                    ->take(3)
                    ->get();

        $testimonies = Post::where('post_type', 'testimony')
                        ->latest()
                        ->take(3)
                        ->get();

        $testimonials = Testimonial::latest()
                        ->take(3)
                        ->get();

        $orderOfWorship = \App\Models\OrderOfWorship::where('type', 'order_of_worship')->latest()->first();
        $pastorDevotion = \App\Models\OrderOfWorship::where('type', 'pastor_devotion')->latest()->first();

        return view('welcome', compact('events', 'sermons', 'testimonies', 'orderOfWorship', 'pastorDevotion', 'testimonials'));
    }
}
