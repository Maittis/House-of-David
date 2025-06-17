@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Create New Blog Post</h1>

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

    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="post_type">Post Type</label>
            <select name="post_type" id="post_type" class="form-control">
                <option value="" disabled selected>Select post type</option>
                <option value="event" {{ old('post_type') == 'event' ? 'selected' : '' }}>Event</option>
                <option value="sermon" {{ old('post_type') == 'sermon' ? 'selected' : '' }}>Sermon</option>
                <option value="testimony" {{ old('post_type') == 'testimony' ? 'selected' : '' }}>Testimony</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="content">Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" rows="8" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image">Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control-file" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Create Post</button>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
