@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Attendance Management</h1>

    {{-- Attendance Marking Form --}}
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Mark Attendance</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="member_id" class="form-label">Select Member:</label>
                    <select name="member_id" id="member_id" class="form-select" required>
                        <option value="">-- Select Member --</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label for="service_id" class="form-label">Service:</label>
                    <select name="service_id" id="service_id" class="form-select" required>
                        <option value="{{ $defaultService->id }}" selected>{{ $defaultService->name }}</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Mark Attendance</button>
            </form>
        </div>
    </div>

    {{-- Present Members --}}
    {{-- <form method="GET" action="{{ route('admin.attendance.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search members by name..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form> --}}

<div class="card mb-5 shadow-sm">
    <div class="card-header bg-success text-white">
        <h2 class="mb-0">Present Members for {{ $defaultService->name }}</h2>
    </div>
    <div class="card-body">
        @if ($presentMembers->isEmpty())
            <p class="text-center text-muted">No members have been marked as present today.</p>
        @else
            <table class="table table-striped table-hover">
                <thead class="table-success">
                    <tr>
                        <th>Name</th>
                        <th>Mobile Number</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presentMembers as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->mobile_number }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination Links --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $presentMembers->links() }}
            </div>
        @endif
    </div>
</div>


    {{-- Absent Members
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h2 class="mb-0">Absent Members for {{ $defaultService->name }}</h2>
        </div>
        <div class="card-body">
            @if ($absentMembers->isEmpty())
                <p class="text-center text-muted">All members have attended today. 🎉</p>
            @else
                <table class="table table-striped table-hover">
                    <thead class="table-danger">
                        <tr>
                            <th>Name</th>
                            <th>Mobile Number</th>
                            <th>Last Attendance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absentMembers as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->mobile_number }}</td>
                                <td>{{ $member->last_attendance ? \Carbon\Carbon::parse($member->last_attendance)->format('Y-m-d') : 'Never' }}</td>
                                <td>
                                    <form action="{{ route('admin.attendance.sms') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                                        <button type="submit" class="btn btn-warning btn-sm">Send SMS</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div> --}}
</div>
@endsection
