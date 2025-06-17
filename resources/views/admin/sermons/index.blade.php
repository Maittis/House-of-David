@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Sermons</h1>

    <a href="{{ route('admin.sermons.create') }}" class="btn btn-primary mb-3">Add New Sermon</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($sermons->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sermons as $sermon)
                <tr>
                    <td>{{ $sermon->title }}</td>
                    <td>
                        <iframe width="200" height="113" src="https://www.youtube-nocookie.com/embed/{{ \Illuminate\Support\Str::afterLast($sermon->video_url, '/') }}" frameborder="0" allowfullscreen></iframe>
                    </td>
                    <td>
                        <a href="{{ route('admin.sermons.edit', $sermon) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.sermons.destroy', $sermon) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this sermon?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $sermons->links() }}
    @else
        <p>No sermons found.</p>
    @endif
</div>
@endsection
