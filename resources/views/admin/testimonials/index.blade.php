@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Testimonials</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary mb-3">Add New Testimonial</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($testimonials->isEmpty())
        <p>No testimonials found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Author Name</th>
                    <th>Rating</th>
                    <th>Text</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $testimonial)
                <tr>
                    <td>{{ $testimonial->author_name }}</td>
                    <td>{{ $testimonial->rating }}</td>
                    <td>{{ $testimonial->text }}</td>
                    <td>
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this testimonial?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
