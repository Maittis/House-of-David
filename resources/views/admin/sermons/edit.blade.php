@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Sermon</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sermons.update', $sermon) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title *</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $sermon->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">Video URL *</label>
            <input type="url" class="form-control" id="video_url" name="video_url" value="{{ old('video_url', $sermon->video_url) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Sermon</button>
        <a href="{{ route('admin.sermons.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
