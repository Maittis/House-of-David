@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Edit About Us</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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

    <form action="{{ route('admin.about.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="content">Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" rows="10" class="form-control" required>{{ old('content', $about->content ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update About Us</button>
    </form>
</div>
@endsection
