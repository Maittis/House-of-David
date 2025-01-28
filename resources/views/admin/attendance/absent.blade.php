


@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-danger text-white">
            <h2 class="mb-0">
    Absent Members for {{ $defaultService->name ?? 'sunday service' }}
</h2>

        </div>
        <div class="card-body">

            {{-- SMS Compose Form --}}
            @if (!$absentMembers->isEmpty())
                <div class="mb-4">
<form action="{{ route('admin.attendance.absent.sms') }}" method="POST">
 @csrf
 <div class="form-group">
<label for="sms_message" class="form-label">Compose SMS:</label>
 <textarea
 name="sms_message"
 id="sms_message"
class="form-control"
 rows="4"
 placeholder="Enter your message here..."
 required
></textarea>
 </div>
 <button type="submit" class="btn btn-primary mt-3">Send SMS to All Absent Members</button>
</form>
                </div>
            @endif

            {{-- Absent Members Table --}}
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
                                    <form action="{{ route('attendance.sms') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                                        <button type="submit" class="btn btn-warning btn-sm">Send SMS1</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection






