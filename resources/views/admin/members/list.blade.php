<!-- resources/views/admin/members/list.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Members List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Services Attended</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->mobile_number }}</td>
                    <td>
                        @foreach($member->services as $service)
                            {{ $service->name }} ({{ $service->pivot->date }})<br>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('admin.members.edit', $member->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.members.delete', $member->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
