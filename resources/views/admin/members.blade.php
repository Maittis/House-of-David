@extends('layouts.app')

@section('content')
    <h1>Members</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Last Attendance</th>
                <th>Attendances Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->mobile_number }}</td>
                    <td>
                        {{ $member->last_attendance ? \Carbon\Carbon::parse($member->last_attendance)->format('Y-m-d') : 'Never' }}
                    </td>

                    <td>{{ $member->attendances_count }}</td>
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



{{-- 1-02-2025

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Last Attendance</th>
            <th>Attendances Count</th>
            <th>Status</th> <!-- New column for status -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($members as $member)
            <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->mobile_number }}</td>
                <td>
                    {{ $member->last_attendance ? \Carbon\Carbon::parse($member->last_attendance)->format('Y-m-d') : 'Never' }}
                </td>
                <td>{{ $member->attendances_count }}</td>
                <td>
                    @if ($member->active)
                        <span class="badge badge-success">Active</span>  <!-- Assuming you have Bootstrap badges -->
                    @else
                        <span class="badge badge-secondary">Inactive</span>
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
</table> --}}



    <!-- Pagination Links -->
    <div class="d-flex justify-content-center">
        {{ $members->links() }}
    </div>
@endsection
