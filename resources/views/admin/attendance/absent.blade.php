@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-danger text-white p-3">
            <h2 class="mb-0 text-center">
                Absent Members for {{ $defaultService->name ?? 'Sunday Service' }}
            </h2>
        </div>
        <div class="card-body p-4">

            @if (!$absentMembers->isEmpty())
                <form action="{{ route('admin.attendance.absent.sms') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="form-group">
                        <label for="sms_message" class="form-label">Compose SMS:</label>
                        <textarea name="sms_message" id="sms_message" class="form-control" rows="4" placeholder="Enter your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Send SMS to All Absent Members</button>
                </form>
            @endif

            @if ($absentMembers->isEmpty())
                <p class="text-center text-muted h5">All members have attended today. 🎉</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Mobile Number</th>
                                <th scope="col">Last Attendance</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absentMembers as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->mobile_number }}</td>
                                    <td>{{ $member->last_attendance ? \Carbon\Carbon::parse($member->last_attendance)->format('Y-m-d') : 'Never' }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.attendance.sms') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="member_id" value="{{ $member->id }}">
                                            <button type="submit" class="btn btn-warning btn-sm">Send SMS</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                @if ($absentMembers instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-3">
                        {{ $absentMembers->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection
