{{-- @extends('layouts.app')

@section('content')
    <h1>Select Service for Attendance</h1>

    @if($services->count() > 0)
        <div class="card">
            <div class="card-body">
                <!-- Service Selection -->
                <form id="selectServiceForm" action="" method="GET">
                    @csrf
                    <div class="form-group">
                        <label for="service">Select a Service:</label>
                        <select name="serviceId" id="service" class="form-control" onchange="this.form.submit()" required>
                            <option value="" selected disabled>Choose a Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ isset($service) && $service->id == request('serviceId') ? 'selected' : '' }}>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <!-- Attendance Recording Section -->
                @if(isset($service))
                    <h2 class="mt-4">Record Attendance for {{ $service->name }}</h2>
                @else
                    <h2 class="mt-4">Search Members</h2>
                @endif

                <!-- Search Members -->
                <form action="{{ route('admin.attendance.list') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by name or number" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>

                <!-- Members Table -->
                @if($members->count() > 0)
                    <form action="{{ isset($service) ? route('admin.save.attendance.for.service', ['serviceId' => $service->id]) : '' }}" method="POST">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Name</th>
                                    <th>Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="members[]" value="{{ $member->id }}">
                                        </td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->mobile_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(isset($service))
                            <button type="submit" class="btn btn-primary mt-3">Record Attendance</button>
                        @endif
                    </form>
                @else
                    <p>No members found.</p>
                @endif
            </div>
        </div>
    @else
        <p>No services available.</p>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('service');
    const form = document.getElementById('selectServiceForm');

    select.addEventListener('change', function () {
        if (this.value) {
            form.action = '{{ url('admin/attendance/service') }}/' + this.value;
        } else {
            form.action = '';
        }
    });

    // Set initial action if a service is already selected
    if (select.value) {
        form.action = '{{ url('admin/attendance/service') }}/' + select.value;
    }
});

    </script>
@endpush --}}
