@extends('layouts.memberhouse')

@section('content')
    <div class="container">
        <h1>{{ $video->title }}</h1>
        <video controls src="{{ $video->url }}"></video>

        <h2>Comments</h2>
        @foreach($comments as $comment)
            <div>{{ $comment->body }}</div>
        @endforeach

        <form action="{{ route('memberArea.comment.submit', $video->id) }}" method="POST">
            @csrf
            <!-- Comment form fields -->
        </form>
    </div>
@endsection
