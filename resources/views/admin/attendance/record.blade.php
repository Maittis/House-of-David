{{-- <!-- resources/views/admin/attendance/record.blade.php -->
@extends('layouts.app')

@section('content')
    @if(isset($service))
        <div class="card mb-4 shadow-lg">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Record Attendance for {{ $service->name }}</h1>

                <!-- Search Form -->
                <form action="{{ route('admin.attendance.for.service', ['serviceId' => $service->id]) }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Search by name or number" value="{{ $search }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </form>

                <!-- Record Attendance Button Moved Up -->
                <form action="{{ route('admin.save.attendance.for.service', ['serviceId' => $service->id]) }}" method="POST" class="mb-4">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg btn-block">Record Attendance</button>
                </form>

                <!-- Attendance Form with Pagination -->
                <form action="{{ route('admin.save.attendance.for.service', ['serviceId' => $service->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="members" class="mb-2">Select Members Present:</label>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col"><input type="checkbox" id="selectAll" onclick="toggleCheckboxes(this)"></th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Mobile Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($members as $member)
                                    <tr>
                                        <td><input type="checkbox" name="members[]" value="{{ $member->id }}"></td>
                                        <td>{{ $member->name }}</td>
                                        <td>{{ $member->mobile_number }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{-- <div class="d-flex justify-content-center mt-3">
                        {{ $members->links() }}
                    </div>
                </form>

                <div class="mt-3">
                    <a href="{{ route('admin.attendance.for.service', ['serviceId' => $service->id]) }}" class="btn btn-warning">View Absent Members</a>

                    <form action="{{ route('admin.send.sms.to.absent') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning ml-2" onclick="return confirm('Are you sure you want to send SMS to all absent members?')">Send SMS to Absent</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            <p>Service not found or not specified.</p>
        </div>
    @endif

    @push('scripts')
        <script>
            function toggleCheckboxes(source) {
                checkboxes = document.getElementsByName('members[]');
                for(var i=0, n=checkboxes.length;i<n;i++) {
                    checkboxes[i].checked = source.checked;
                }
            }
        </script>
    @endpush
@endsection --}} --}}
