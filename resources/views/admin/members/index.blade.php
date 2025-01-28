@extends('layouts.app')

@section('content')
    <h1>Member Management</h1>

    <!-- Add Member Button -->
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary mb-3">+ Add Member</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Last Attendance</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->mobile_number }}</td>
                    <td>{{ $member->last_attendance ? \Carbon\Carbon::parse($member->last_attendance)->format('Y-m-d') : 'Never' }}</td>
                    <td>
                        @if(now()->subWeek()->gte(\Carbon\Carbon::parse($member->last_attendance ?? now())))
                            <span class="badge bg-warning">Follow-up</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.members.edit', $member) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('admin.members.delete', $member) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $members->links() }}
@endsection
