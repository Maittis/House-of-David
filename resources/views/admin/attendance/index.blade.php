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
                    <label for="member_search" class="form-label">Search Member:</label>
                    <input type="text" class="form-control" id="member_search" placeholder="Search for member...">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Select Members:</label>
                    @foreach ($members as $member)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="member_ids[]" value="{{ $member->id }}">
                            <label class="form-check-label" for="member_{{ $member->id }}">{{ $member->name }}</label>
                        </div>
                    @endforeach
                </div>
<div class="form-group mb-4">
    <label for="service_id" class="form-label">Service:</label>
    <select name="service_id" id="service_id" class="form-select" required>
        <option value="" disabled selected>Select a service</option>
        @forelse($services ?? [] as $service)
            <option 
                value="{{ $service->id }}" 
                {{ ($defaultService && $defaultService->id == $service->id) ? 'selected' : '' }}
            >
                {{ $service->name }}
            </option>
        @empty
            <option value="" disabled>No services available</option>
        @endforelse
    </select>
    @error('service_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

                <button type="submit" class="btn btn-primary w-100">Mark Attendance</button>
            </form>

            <div class="d-flex justify-content-center mt-3">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    {{-- Present Members --}}
    @if($defaultService)
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
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presentMembers as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->mobile_number }}</td>
                                <td>{{ $member->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-3">
                    {{ $presentMembers->links() }}
                </div>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('member_search');
        var checkboxes = document.querySelectorAll('.form-check-input');

        searchInput.addEventListener('input', function() {
            var filter = searchInput.value.toLowerCase();
            Array.from(checkboxes).forEach(function(checkbox) {
                var label = checkbox.nextElementSibling;
                if (label.textContent.toLowerCase().includes(filter)) {
                    checkbox.parentElement.style.display = "";
                } else {
                    checkbox.parentElement.style.display = "none";
                }
            });
        });
    });
</script>
@endsection
