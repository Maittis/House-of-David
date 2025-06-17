@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Order of Worship / Pastor's Devotion</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.order_of_worship.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="" disabled selected>Select type</option>
                <option value="order_of_worship" {{ old('type') == 'order_of_worship' ? 'selected' : '' }}>Order of Worship</option>
                <option value="pastor_devotion" {{ old('type') == 'pastor_devotion' ? 'selected' : '' }}>Pastor's Devotion</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea name="content" id="content" rows="8" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image (optional)</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">Video URL (optional)</label>
            <input type="url" name="video_url" id="video_url" class="form-control" value="{{ old('video_url') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
        <a href="{{ route('admin.order_of_worship.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
