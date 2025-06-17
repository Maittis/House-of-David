@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Absent Members Report</h2>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('admin.absent-members.weekly-report') }}" class="btn btn-info">Weekly Report</a>
                <a href="{{ route('admin.absent-members.monthly-report') }}" class="btn btn-secondary">Monthly Report</a>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Last Attendance</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absentMembers as $index => $member)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->last_attendance ?? 'Never' }}</td>
                            <td>
                                @if($member->last_attendance)
                                    <span class="badge bg-warning">Recently Attended</span>
                                @else
                                    <span class="badge bg-danger">Long Time Absent</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
