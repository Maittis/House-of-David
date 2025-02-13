<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Attendance Tracker @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('styles')

</head>
<body>


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


<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #afed5d; border-bottom: 2px solid #ffffff;">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" style="height: 60px; margin-right: 10px;">
            <span style="font-size: 1.5rem; font-weight: bold; color: #ffffff;">Admin Panel</span>
        </a>
        <!-- Toggle Button for Mobile View -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-primary fw-semibold" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary fw-semibold" href="{{ route('admin.members') }}">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary fw-semibold" href="{{ route('admin.attendance.index') }}">Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary fw-semibold" href="{{ route('admin.inquiries') }}">Inquiries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary fw-semibold" href="{{ route('admin.inspirational_messages') }}">Inspirational Messages</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-primary fw-semibold" href="{{ route('admin.followup.index') }}">Follow Up Team</a>
                </li>
            </ul>
        </div>
    </div>


    <div class="theme-switch-wrapper">
        <label class="theme-switch" for="theme-toggle">
            <input type="checkbox" id="theme-toggle">
            <div class="slider round"></div>
        </label>
        <span>Dark Mode</span>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-3">Watch Services</h2>
            <div id="fb-root"></div>
            <script async defer crossorigin="anonymous" src="https://www.facebook.com/settings/?tab=profile" nonce="YOUR_NONCE"></script>
            <div class="fb-page"
                data-href="YOUR_FACEBOOK_PAGE_URL"
                data-tabs="timeline"
                data-width=""
                data-height="500"
                data-small-header="false"
                data-adapt-container-width="true"
                data-hide-cover="false"
                data-show-facepile="true">
                <blockquote cite="https://web.facebook.com/Past332" class="fb-xfbml-parse-ignore"><a href="https://web.facebook.com/Past332">House of David Parish</a></blockquote>
            </div>
        </div>
    </div>

</div>


    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">

    </script>
    @yield('scripts')




</body>
</html>
