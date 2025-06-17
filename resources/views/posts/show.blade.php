{{-- @extends('layouts.auth')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        @if ($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" alt="{{ $post->title }}" class="img-fluid mb-6">
        @else
            <p>No image available for this post.</p>
        @endif
        <p>{{ $post->content }}</p>
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection --}}
