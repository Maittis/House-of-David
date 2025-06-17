@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Edit Blog Post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="post_type">Post Type</label>
            <select name="post_type" id="post_type" class="form-control">
                <option value="" disabled>Select post type</option>
                <option value="event" {{ old('post_type', $blog->post_type) == 'event' ? 'selected' : '' }}>Event</option>
                <option value="sermon" {{ old('post_type', $blog->post_type) == 'sermon' ? 'selected' : '' }}>Sermon</option>
                <option value="testimony" {{ old('post_type', $blog->post_type) == 'testimony' ? 'selected' : '' }}>Testimony</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="content">Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" rows="8" class="form-control" required>{{ old('content', $blog->content) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label>Current Image</label><br>
            @if($blog->image_path)
                <img src="{{ asset('storage/' . $blog->image_path) }}" alt="Current Image" style="max-width: 300px; max-height: 200px;">
            @else
                <p>No image uploaded.</p>
            @endif
        </div>

        <div class="form-group mb-3">
            <label for="image">Change Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Update Post</button>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
