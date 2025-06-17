<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Attendance Tracker @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="d-flex flex-column flex-shrink-0 p-3 bg-dark" style="width: 250px; min-height: 100vh;">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('images/Saint1.png') }}" alt="Logo" style="height: 40px; margin-right: 10px; filter: brightness(0) invert(1);">
                <span class="fs-4">Admin Panel</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link text-white py-2 active" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.members') }}">
                        <i class="fas fa-users me-2"></i>Members
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.attendance.index') }}">
                        <i class="fas fa-calendar-check me-2"></i>Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.inquiries') }}">
                        <i class="fas fa-question-circle me-2"></i>Inquiries
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.inspirational_messages') }}">
                        <i class="fas fa-quote-left me-2"></i>Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.followup.index') }}">
                        <i class="fas fa-hands-helping me-2"></i>Follow Up
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.contacts.index') }}">
                        <i class="fas fa-hands-helping me-2"></i>Contacts
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('posts.index') }}">
                        <i class="fas fa-blog me-2"></i>Blog
                    </a>
                </li>

                 <li class="nav-item">
                    <a class="nav-link text-white py-2" href="{{ route('admin.hero-section.index') }}">
                        <i class="fas fa-blog me-2"></i>Manage HeroSection
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-2">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <strong>Admin</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sign out</a></li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1" style="padding: 20px;">
            <!-- Alerts -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Content Section -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    @yield('scripts')

    <style>
        body {
            overflow-x: hidden;
        }

        .nav-pills .nav-link.active {
            background-color: rgba(255,255,255,0.1);
        }

        .nav-pills .nav-link {
            border-radius: 4px;
            margin-bottom: 5px;
            transition: all 0.3s;
        }

        .nav-pills .nav-link:hover {
            background-color: rgba(255,255,255,0.05);
        }

        .avatar {
            width: 32px;
            height: 32px;
            display: flex;
        }

        .dropdown-menu-dark {
            background-color: #343a40;
            border: none;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
        }

        .dropdown-item:hover {
            background-color: rgba(255,255,255,0.1);
        }
    </style>
</body>
</html>
