{{-- @extends('layouts.app')

@section('title', 'Absent Members for ' . $service->name)

@section('service-info')
    <h1>Absent Members for {{ $service->name }}</h1>
@endsection

@section('content')
    <!-- Form to view absent members for this service -->
    <form action="{{ route('admin.absent.members.for.service', ['serviceId' => $service->id]) }}" method="GET">
        @csrf
        <button type="submit" class="btn btn-secondary mb-3">View Absent Members</button>
    </form>

    <!-- Button to open modal for sending SMS -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#sendSMSModal">Send SMS to All Absent Members</button>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Last Attendance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absentMembers as $member)
                <tr>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->mobile_number }}</td>
                    <td>{{ $member->last_attendance ? \Carbon\Carbon::parse($member->last_attendance)->format('Y-m-d') : 'Never' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $absentMembers->links() }}

    <!-- Modal for sending SMS -->
    <div class="modal fade" id="sendSMSModal" tabindex="-1" aria-labelledby="sendSMSModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendSMSModalLabel">Send Follow-up SMS to All Absent Members for {{ $service->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.send.sms.to.absent.for.service', $service->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <textarea name="message" class="form-control" rows="4" placeholder="Enter your follow-up message here" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send SMS</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection --}}
