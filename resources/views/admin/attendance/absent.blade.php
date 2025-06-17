@extends('layouts.app')

@section('content')



<div class="mb-3 text-center">
    <button type="button" class="btn btn-primary" id="generateWeeklyReport">Generate Weekly Report</button>
    <button type="button" class="btn btn-secondary" id="generateMonthlyReport">Generate Monthly Report</button>
</div>



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
                    <div class="form-group mb-3">
                        <label for="sms_provider">SMS Provider:</label>
                        <select name="provider" id="sms_provider" class="form-control" required>
                            <option value="twilio">Twilio</option>
                            <option value="textme">TextMe</option>
                            <option value="pingme">PingMe</option>
                            <option value="pingme">Whatsapp</option>
                        </select>
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
                                            <input type="hidden" name="provider" value="twilio">
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




<script>
    document.getElementById('generateWeeklyReport').addEventListener('click', function() {
        window.location.href = "{{ route('admin.attendance.report', ['type' => 'weekly']) }}";
    });

    document.getElementById('generateMonthlyReport').addEventListener('click', function() {
        window.location.href = "{{ route('admin.attendance.report', ['type' => 'monthly']) }}";
    });
</script>


@endsection
