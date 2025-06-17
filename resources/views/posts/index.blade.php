{{-- <!-- resources/views/posts/index.blade.php -->

@extends('layouts.auth')  <!-- Replace with your base layout -->

@section('content')
    <div class="container">
        <h1>Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif

        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach

        {{ $posts->links() }}
    </div>
@endsection --}}
