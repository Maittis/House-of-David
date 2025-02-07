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


    {{-- <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile Number</th>
                <th>Services Attended</th>
                <th>Attendances Count</th>
                <th>Status</th>
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
                        <span class="badge {{ $member->status == 'inactive' ? 'badge-secondary' : 'badge-success' }}">
                            {{ $member->status == 'inactive' ? 'Inactive' : 'Active' }}
                        </span>
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



@endsection
