@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add New Testimonial</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="author_name" class="form-label">Author Name</label>
            <input type="text" class="form-control" id="author_name" name="author_name" value="{{ old('author_name') }}" required>
        </div>
        <div class="mb-3">
            <label for="author_image" class="form-label">Author Image (optional)</label>
            <input type="file" class="form-control" id="author_image" name="author_image" accept="image/*">
        </div>
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1-5)</label>
            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="{{ old('rating') }}" required>
        </div>
        <div class="mb-3">
            <label for="text" class="form-label">Testimonial Text</label>
            <textarea class="form-control" id="text" name="text" rows="4" required>{{ old('text') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Testimonial</button>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
