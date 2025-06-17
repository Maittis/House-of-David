@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order of Worship & Pastor's Devotions</h1>
    <a href="{{ route('admin.order_of_worship.create') }}" class="btn btn-primary mb-3">Add New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($items->isEmpty())
        <p>No entries found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->type)) }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.order_of_worship.edit', $item) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.order_of_worship.destroy', $item) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
