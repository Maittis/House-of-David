<!-- resources/views/layouts/member.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <!-- Include your CSS files -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
    <style>
        /* Basic Reset */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        /* Header Styles */
        header {
            background-color: #007bff;
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
            transition: opacity 0.3s;
        }
        .navbar a:hover {
            opacity: 0.7;
        }
        .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
        }

        /* Main Content Styles */
        main {
            padding: 50px;
            margin: 50px;
        }

        /* Footer Styles */
        /* footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .footer-links a {
            color: #adb5bd;
            text-decoration: none;
            margin: 0 10px;
        }
        .footer-links a:hover {
            color: #ced4da;
        } */
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="{{ route('home') }}" class="navbar-brand">House of David Parish</a>
            <div class="nav-links">
                <a href="{{ route('memberArea.dboard') }}">Dashboard</a>
                {{-- <a href="{{ route('memberArea.services') }}">Services</a>
                <a href="{{ route('memberArea.messages') }}">Messages</a>
                <a href="{{ route('memberArea.profile') }}">Profile</a> --}}
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </nav>
    </header>
    <main>
        @yield('content')


        <div class="container-fluid dashboard-container">
            <div class="col-md-4">
                <div class="card inspiration-card">
                    <div class="card-body">
                        <h3 class="card-title">Daily Inspiration</h3>
                        @if(isset($inspirationalMessages) && $inspirationalMessages->isNotEmpty())
                            <p class="card-text text-muted">{{ $inspirationalMessages->first()->content }}</p>
                            <p class="date-text">{{ $inspirationalMessages->first()->created_at->format('Y-m-d') }}</p>
                        @else
                            <p class="card-text text-muted">No inspirational messages available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/admin/get-latest-inspiration')
            .then(response => response.json())
            .then(data => {
                document.getElementById('inspiration-content').textContent = data.content;
                document.getElementById('inspiration-date').textContent = data.date;
            })
            .catch(error => console.error('Error fetching inspiration:', error));
        });
        </script>


    </main>









    <footer>
        {{-- <div class="footer-links">
            <a href="{{ route('about') }}">About Us</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="{{ route('privacy') }}">Privacy Policy</a>
            <a href="{{ route('terms') }}">Terms of Service</a>
        </div> --}}
    </footer>
    <!-- Include your JS files -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
