@extends('layouts.app')

<style>
    :root {
        --primary: #4CAF50; /* Vibrant green */
        --primary-light: #81C784;
        --primary-dark: #388E3C;
        --secondary: #2196F3; /* Bright blue */
        --secondary-light: #64B5F6;
        --secondary-dark: #1976D2;
        --accent: #FF5722; /* Orange */
        --danger: #F44336; /* Red */
        --warning: #FFC107; /* Amber */
        --success: #4CAF50; /* Green */
        --info: #00BCD4; /* Cyan */

        --dark: #263238; /* Dark blue-gray */
        --light: #ECEFF1; /* Light blue-gray */
        --gray: #90A4AE; /* Medium blue-gray */

        --text-color: #37474F;
        --text-light: #546E7A;
        --bg-color: #F5F7FA;
        --card-bg: #FFFFFF;
        --card-shadow: rgba(0, 0, 0, 0.08);
        --border-color: #CFD8DC;
    }

    [data-theme="dark"] {
        --primary: #66BB6A;
        --primary-light: #81C784;
        --primary-dark: #43A047;
        --secondary: #42A5F5;
        --secondary-light: #64B5F6;
        --secondary-dark: #1E88E5;
        --accent: #FF7043;
        --danger: #EF5350;
        --warning: #FFA726;
        --success: #66BB6A;
        --info: #26C6DA;

        --dark: #121212;
        --light: #1E1E1E;
        --gray: #757575;

        --text-color: #E0E0E0;
        --text-light: #B0B0B0;
        --bg-color: #121212;
        --card-bg: #1E1E1E;
        --card-shadow: rgba(0, 0, 0, 0.3);
        --border-color: #424242;
    }

    body {
        background: var(--bg-color);
        color: var(--text-color);
        font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        transition: all 0.3s ease;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .navbar {
        background: var(--dark);
        padding: 1.2rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 0 0 12px 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .navbar h1 {
        color: white;
        margin: 0;
        font-size: 1.8em;
        font-weight: 600;
        letter-spacing: -0.5px;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .nav-links a:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        margin: 4px;
        font-size: 0.9em;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-secondary {
        background: var(--secondary);
        color: white;
    }

    .btn-secondary:hover {
        background: var(--secondary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #D32F2F;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-warning {
        background: var(--warning);
        color: #212121;
    }

    .btn-warning:hover {
        background: #FFA000;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-accent {
        background: var(--accent);
        color: white;
    }

    .btn-accent:hover {
        background: #E64A19;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .card {
        background: var(--card-bg);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 12px var(--card-shadow);
        margin-bottom: 25px;
        transition: transform 0.3s, box-shadow 0.3s;
        border: 1px solid var(--border-color);
    }

    .card:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        z-index: 10;
    }

    .card-body {
        position: relative;
        z-index: 1;
    }

    .card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.1) 0%, transparent 20%);
        opacity: 0.3;
        pointer-events: none;
        border-radius: inherit;
    }

    .card-title {
        color: var(--text-color);
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.2em;
    }

    .card-text {
        color: var(--text-light);
        margin-bottom: 0.5rem;
    }

    .display-4 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-color);
        margin: 10px 0;
    }

    .text-success {
        color: var(--success) !important;
    }

    .text-warning {
        color: var(--warning) !important;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .text-info {
        color: var(--info) !important;
    }

    .clickable-card {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .clickable-card:hover {
        border-color: var(--primary);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--text-color);
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: border-color 0.3s;
        background: var(--card-bg);
        color: var(--text-color);
    }

    .form-control:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .modal-content {
        background: var(--card-bg);
        color: var(--text-color);
        border: 1px solid var(--border-color);
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color);
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
    }

    .theme-switch-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .theme-switch {
        display: inline-block;
        height: 34px;
        position: relative;
        width: 60px;
    }

    .theme-switch input {
        display: none;
    }

    .slider {
        background-color: var(--gray);
        bottom: 0;
        cursor: pointer;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: .4s;
    }

    .slider:before {
        background-color: white;
        bottom: 4px;
        content: "";
        height: 26px;
        left: 4px;
        position: absolute;
        transition: .4s;
        width: 26px;
    }

    input:checked + .slider {
        background-color: var(--primary);
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }




</style>

@section('content')


    <div class="row">
       <!-- Total Members Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card" onclick="location.href='{{ route('admin.members.index') }}'"
         style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Total Members</h5>
            <p class="card-text" style="font-size: 1.5rem;">{{ $totalMembers }}</p>
            <p class="card-text" style="color: #f7f7f7; font-size: 0.8rem;">↑ 5% this month</p>
        </div>
    </div>
</div>

    <!-- Present Today Card -->
    <div class="col-md-3">
        <div class="card text-center clickable-card"
             style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; border: none; border-radius: 10px;">
            <div class="card-body" style="padding: 0.5rem;">
                <h5 class="card-title" style="font-size:1rem;">Present Today</h5>
                <p class="card-text" style="font-size: 1rem;">{{ $presentToday }}</p>
                <p class="card-text" style="color: #fafafa;">{{ $totalMembers > 0 ? number_format(($presentToday / $totalMembers) * 100, 1) : 0 }}% attendance</p>
            </div>
        </div>
    </div>

    <!-- Absent Today Card -->
@if(isset($services) && $services->isNotEmpty())
    @php
        $service = $services->first();
    @endphp
    <div class="col-md-3">
        <div class="card text-center clickable-card"
             style="background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%); color: #2c3e50; border: none; border-radius: 8px; padding: 0.5rem;">
            <div class="card-body" style="padding: 0.5rem;">
                <h5 class="card-title" style="font-size: 1rem;">Absent Members for {{ $service->name ?? 'Sunday Service' }}</h5>
                <p class="card-text" style="font-size: 1.5rem;">{{ $absentToday ?? 0 }}</p>
                <p class="card-text" style="color: #7d5a10; font-size: 0.8rem;">Needs follow-up</p>
                <a href="{{ isset($service) ? route('admin.absent.members.for.service', ['serviceId' => $service->id]) : '#' }}"
                   class="btn btn-sm py-1" style="background-color: #2c3e50; color: white; font-size: 0.8rem;">
                    View Absent Members
                </a>
            </div>
        </div>
    </div>
@else
    <div class="col-md-3">
        <div class="alert alert-info text-center py-2" style="border-radius: 8px; font-size: 0.9rem;">
            No services available to display attendance for.
        </div>
    </div>
@endif

    <!-- New Members Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card" onclick="location.href='{{ route('admin.new-members') }}'"
         style="background: linear-gradient(135deg, #36b9cc 0%, #258391 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">New Members</h5>
            <p class="card-text" style="font-size: 1.5rem;">{{ $newMembersThisMonth }}</p>
            <p class="card-text" style="color: #c0f0f7; font-size: 0.8rem;">This month</p>
        </div>
    </div>
</div>

    <!-- Manage Events Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card" onclick="location.href='{{ route('admin.events.index') }}'"
         style="background: linear-gradient(135deg, #f39c12 0%, #d35400 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Manage Events</h5>
            <p class="card-text" style="font-size: 1.5rem;">Events</p>
            <p class="card-text" style="color: #f7c97b; font-size: 0.8rem;">Create and edit events</p>
        </div>
    </div>
</div>

<!-- Manage Order of Worship Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card" onclick="location.href='{{ url('/admin/order_of_worship') }}'"
         style="background: linear-gradient(135deg, #6f42c1 0%, #563d7c 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Manage Order of Worship</h5>
            <p class="card-text" style="font-size: 1.5rem;">Order of Worship & Devotions</p>
            <p class="card-text" style="color: #d7c9f7; font-size: 0.8rem;">Create and edit worship content</p>
        </div>
    </div>
</div>

<!-- Manage Sermons Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card" onclick="location.href='{{ route('admin.sermons.index') }}'"
         style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Manage Sermons</h5>
            <p class="card-text" style="font-size: 1.5rem;">Sermons</p>
            <p class="card-text" style="color: #a3c8ff; font-size: 0.8rem;">Add and edit sermons with video</p>
        </div>
    </div>
</div>
    <div class="row">
        <!-- Spiritual Milestones Card -->
       <div class="col-md-3">
    <div class="card text-center clickable-card card-spiritual-milestones" onclick="location.href='{{ route('admin.inspirational_messages') }}'"
         style="background: linear-gradient(135deg, #9c27b0 0%, #673ab7 100%); color: white; border: none; border-radius: 8px;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Spiritual Milestones</h5>
            <p class="card-text" style="font-size: 1.5rem;">{{ $spiritualMilestonesCount ?? 0 }}</p>
            <p class="card-text" style="color: #e1bee7; font-size: 0.8rem;">Tracked milestones</p>
        </div>
    </div>
</div>


<!-- Donations Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card card-donations" onclick="location.href='{{ route('donations.index') }}'">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Pledge & Donation Tracking</h5>
            <p class="card-text" style="font-size: 1.5rem;">{{ $donationsCount ?? 0 }}</p>
            <p class="card-text" style="color: #e1bee7; font-size: 0.8rem;">Total donations</p>
        </div>
    </div>
</div>


<!-- Manage Blog Card -->
<div class="col-md-3">
<div class="card text-center clickable-card" onclick="location.href='{{ route('admin.blog.index') }}'"
         style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Manage Blog</h5>
            <p class="card-text" style="font-size: 1.5rem;">Blog Posts</p>
            <p class="card-text" style="color: #ced4da; font-size: 0.8rem;">Create and edit blog posts</p>
        </div>
    </div>
</div>

<!-- Manage Testimonials Card -->
<div class="col-md-3">
    <div class="card text-center clickable-card" onclick="location.href='{{ route('admin.testimonials.index') }}'"
         style="background: linear-gradient(135deg, #ff6f61 0%, #d94f43 100%); color: white; border: none; border-radius: 8px; padding: 0.5rem;">
        <div class="card-body" style="padding: 0.5rem;">
            <h5 class="card-title" style="font-size: 1rem;">Manage Testimonials</h5>
            <p class="card-text" style="font-size: 1.5rem;">Testimonials</p>
            <p class="card-text" style="color: #f7b7b2; font-size: 0.8rem;">Create and edit testimonials</p>
        </div>
    </div>
</div>

    <div class="reporting-sidebar">
      <h4 class="sidebar-header">Analytics & Reports</h4>
       <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('admin.reports.attendance-trends') }}" class="nav-link">
                <i class="fas fa-chart-line"></i>
                <span>Attendance Trends</span>
                <small>Weekly/Monthly/Yearly</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.reports.demographics') }}" class="nav-link">
                <i class="fas fa-users"></i>
                <span>Demographic Reports</span>
                <small>Age groups, gender ratios</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.reports.growth-metrics') }}" class="nav-link">
                <i class="fas fa-seedling"></i>
                <span>Growth Metrics</span>
                <small>New vs. returning</small>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.reports.export') }}" class="nav-link">
                <i class="fas fa-file-export"></i>
                <span>Export Reports</span>
                <small>Excel/PDF/CSV</small>
            </a>
        </li>
    </ul>
</div>

<style>
.reporting-sidebar {
    background: var(--card-bg);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px var(--card-shadow);
    margin-bottom: 25px;
}

.sidebar-header {
    color: var(--primary);
    padding-bottom: 10px;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 15px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    margin-bottom: 8px;
    border-radius: 8px;
    color: var(--text-color);
    transition: all 0.3s ease;
}

.nav-link:hover {
    background: rgba(var(--primary-rgb), 0.1);
    transform: translateX(5px);
}

.nav-link i {
    margin-right: 12px;
    width: 24px;
    text-align: center;
    color: var(--primary);
}

.nav-link span {
    flex-grow: 1;
    font-weight: 500;
}

.nav-link small {
    color: var(--text-light);
    font-size: 0.8em;
    margin-left: 10px;
}
</style>

    {{-- Keep the rest of the existing dashboard content unchanged --}}
    <div class="row mt-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-primary">
                        <i class="fas fa-user-plus me-2"></i>New Members
                    </h5>
                    <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                        <i class="fas fa-plus me-2"></i>Add Member
                    </button>
                </div>

                @if(isset($followUpNeeded))
                <div class="card mt-4 border-left-4 border-left-warning">
                    <div class="card-header bg-light-warning d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">
                            <i class="fas fa-exclamation-circle me-2 text-warning"></i>Member Needing Follow-Up
                        </span>
                        <span class="badge bg-warning text-dark">Priority</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">{{ $followUpNeeded->name }}</h5>
                                <p class="text-muted small mb-2">
                                    <i class="far fa-calendar me-1"></i>
                                    Last Attendance: {{ $followUpNeeded->last_attendance ? \Carbon\Carbon::parse($followUpNeeded->last_attendance)->format('M j, Y') : 'Never' }}
                                </p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="https://wa.me/{{ $followUpNeeded->phone }}" class="btn btn-success rounded-pill me-2" target="_blank">
                                <i class="fab fa-whatsapp me-1"></i> WhatsApp
                            </a>
                            <a href="tel:{{ $followUpNeeded->phone }}" class="btn btn-outline-primary rounded-pill">
                                <i class="fas fa-phone me-1"></i> Call
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="alert alert-light-info border border-light-info mt-4 d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-3 text-info"></i>
                    <div>
                        <h6 class="alert-heading mb-1">All caught up!</h6>
                        <p class="mb-0 small">No members currently need follow-up.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-4 {
        border-left-width: 4px !important;
    }
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.15);
    }
    .bg-light-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }
    .bg-light-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
    }
</style>


    <div class="card mt-4">
        <div class="card-header">
            <h5>Watch Live Streams of Other Men of God</h5>
        </div>
        <div class="card-body">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/live_stream?channel=UCTj7Cw307CYufcKLLizh4MA"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
            </div>
        </div>
    </div>


   <!-- Modal for Adding Member -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-labelledby="addMemberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.members.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter member's name" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile_number" class="form-label">Mobile Number</label>
                        <input type="text" class="form-control" id="mobile_number" name="mobile_number" placeholder="Enter mobile number" required>
                    </div>
                    <div class="mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" placeholder="Enter member's age" min="1" max="120">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="" selected disabled>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
