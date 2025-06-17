@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Blog Posts</h1>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($posts->count())
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Title</th>
                    <th>Post Type</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->post_type ?? '-' }}</td>
                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ route('admin.blog.edit', $post->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.blog.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $posts->links() }}
    @else
        <p>No blog posts found.</p>
    @endif
</div>
@endsection
