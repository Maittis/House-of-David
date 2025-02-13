@extends('layouts.app')



<style>
      :root {
      --primary: #4CAF50;
      --secondary: #2196F3;
      --danger: #f44336;
      --dark: #333;
      --light: #f4f4f4;
      --text-color: #333;
      --bg-color: #fff;
      --card-bg: #fff;
      --card-shadow: rgba(0, 0, 0, 0.1);
    }


    [data-theme="dark"] {
      --primary: #45a049;
      --secondary: #1e88e5;
      --danger: #e53935;
      --dark: #f4f4f4;
      --light: #333;
      --text-color: #f4f4f4;
      --bg-color: #222;
      --card-bg: #333;
      --card-shadow: rgba(255, 255, 255, 0.1);
    }

    body {

        background: var(--bg-color);
      color: var(--text-color);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      line-height: 1.6;
      margin: 0;
      padding: 20px;
      background: #09c0c6; /* Light gray for a softer background */
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .navbar {
      background: var(--dark);
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 2px 5px rgba(174, 29, 29, 0.1);
    }

    .navbar h1 {
      color: white;
      margin: 0;
      font-size: 1.8em;
    }

    .nav-links {
      margin-top: 10px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      margin-right: 15px;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: var(--secondary);
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      margin: 4px;
      font-size: 0.9em;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: var(--primary);
      color: white;
    }

    .btn-primary:hover {
      background: #45a049;
    }

    .btn-secondary {
      background: var(--secondary);
      color: white;
    }

    .btn-secondary:hover {
      background: #1e88e5;
    }

    .btn-danger {
      background: var(--danger);
      color: white;
    }

    .btn-danger:hover {
      background: #e53935;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      background: white;
      box-shadow: 0 4px 8px var(--card-shadow);
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background: var(--dark);
      color: white;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-group label {
      display: block;
      margin-bottom: .5rem;
      font-weight: 600;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      transition: border-color 0.3s;
    }

    .form-control:focus {
      border-color: var(--primary);
      outline: none;
    }

    .card {
        background: var(--card-bg);
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 6px 12px var(--card-shadow);
      margin-bottom: 20px;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px var(--card-shadow);
    }

    /* Rest of the CSS remains the same or slightly adjusted for visual consistency */


    .theme-switch-wrapper {
        display: flex;
        align-items: center;
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
        background-color: #ccc;
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
        background-color: #66bb6a; /* Green for dark mode */
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


    .embed-responsive {
        position: relative;
        display: block;
        width: 100%;
        padding: 0;
        overflow: hidden;
    }

    </style>

@section('content')
    <div class="row">




        <!-- Total Members Card -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Members</h5>
                    <p class="card-text display-4">{{ $totalMembers }}</p>
                    <p class="card-text text-success">↑ 5% this month</p>
                </div>
            </div>
        </div>

        <!-- Present Today Card -->
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Present Today</h5>
                    <p class="card-text display-4">{{ $presentToday }}</p>
                    <p class="card-text">{{ number_format(($presentToday / $totalMembers) * 100, 1) }}% attendance</p>
                </div>
            </div>
        </div>



<!-- Assuming you only want to show for the first service or a specific one -->
@if(isset($services) && $services->isNotEmpty())
    @php
        $service = $services->first(); // or select a specific service if needed
    @endphp
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Absent Members for {{ $service->name ?? 'sunday service' }}</h5>
                <p class="card-text display-4">{{ $absentToday ?? 0 }}</p>
                <p class="card-text text-warning">Needs follow-up</p>
                <a href="{{ isset($service) ? route('admin.absent.members.for.service', ['serviceId' => $service->id]) : '#' }}" class="btn btn-warning">
                    View Absent Members
                </a>
            </div>
        </div>
    </div>
@else
    <div class="col-md-3">
        <div class="alert alert-info text-center">
            No services available to display attendance for.
        </div>
    </div>
@endif




        <!-- New Members Card -->
        <div class="col-md-3">
            <div class="card text-center clickable-card" onclick="location.href='{{ route('admin.new-members') }}'">
                <div class="card-body">
                    <h5 class="card-title">New Members</h5>
                    <p class="card-text display-4">{{ $newMembersThisMonth }}</p>
                    <p class="card-text">This month</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title">New Member</h5>
                        <!-- Here is where we'll add the form for creating a member -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                            + Add Member
                        </button>
                    </div>
                    <table class="table">

                        <tbody>
                            @if(isset($followUpNeeded))
                            <div class="card mt-4">
                                <div class="card-header">
                                    Member Needing Follow-Up
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $followUpNeeded->name }}</h5>
                                    <p class="card-text">Last Attendance: {{ $followUpNeeded->last_attendance ? \Carbon\Carbon::parse($followUpNeeded->last_attendance)->format('Y-m-d') : 'Never' }}</p>
                                    <a href="https://wa.me/{{ $followUpNeeded->phone }}" class="btn btn-primary" target="_blank">Contact</a>

                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mt-4" role="alert">
                                No member currently needs follow-up.
                            </div>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>




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




 <!-- Your existing content here -->

 <div class="d-flex justify-content-end mt-4">
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
        Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>

    {{-- <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Send Inspirational Message</h5>
                    <form action="{{ route('admin.get-latest-inspiration') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}



    {{-- <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Send Inspirational Message</h5>
                    <form action="{{ route('admin.send-inspiration') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <!-- Display recent messages -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Inspirational Messages</h5>
                    <ul class="list-group">
                        @foreach($inspirationalMessages as $message)
                            <li class="list-group-item">
                                <strong>{{ $message->created_at->format('d M Y') }}</strong>: {{ $message->content }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}



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
                        {{-- <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter member's email" required>
                        </div> --}}
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM fully loaded and parsed'); // Check if this logs in your console

            const themeToggle = document.getElementById('theme-toggle');
            if (!themeToggle) {
                console.error('Theme toggle element not found!');
                return;
            }

            let currentTheme = localStorage.getItem('theme') || 'light';

            // Apply the saved theme or default to light
            document.documentElement.setAttribute('data-theme', currentTheme);

            themeToggle.addEventListener('change', function() {
                currentTheme = this.checked ? 'dark' : 'light';
                document.documentElement.setAttribute('data-theme', currentTheme);
                localStorage.setItem('theme', currentTheme);
            });

            // Reflect the current theme in the checkbox
            themeToggle.checked = currentTheme === 'dark';
        });
    </script>

@endsection
