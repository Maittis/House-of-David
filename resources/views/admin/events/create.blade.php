@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Event</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title *</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_datetime" class="form-label">Start Date & Time *</label>
            <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime" value="{{ old('start_datetime') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_datetime" class="form-label">End Date & Time</label>
            <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" value="{{ old('end_datetime') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Event Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Create Event</button>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
