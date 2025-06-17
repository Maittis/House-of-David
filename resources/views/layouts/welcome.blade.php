<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'St Columba’s')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<style>
    /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        nav.scrolled {
            box-shadow: var(--shadow-md);
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.2rem 2rem;
        }

        .logo-link img {
            height: 50px;
            transition: var(--transition);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            position: relative;
            color: var(--secondary);
            font-weight: 500;
            padding: 0.5rem 0;
            transition: var(--transition);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-auth {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

         main img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width: 100%;
        height: auto;
    }
    .event-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.event-details {
    text-align: left;
}

.event-description {
    font-size: 1rem;
    line-height: 1.6;
}


   .blog-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.blog-details {
    text-align: left;
}

.blog-description {
    font-size: 1rem;
    line-height: 1.6;
}
</style>
<body>

    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <a href="/" class="logo-link">
                <img src="{{ asset('images/logo1.png') }}" alt="St Columba's Logo" class="logo">
            </a>

            <div class="nav-links">
                <a href="/">Home</a>
                <a href="/about">About Us</a>
                {{-- <a href="/sermons">Sermons</a> --}}
                {{-- <a href="/events">Events</a> --}}
                <a href="/blog">Blog</a>
                <a href="/contact">Contact</a>
                <a href="/donate">Donate Now</a>
            </div>

            <div class="nav-auth">
                @auth
                    {{-- <a href="{{ url('/dashboard') }}" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">Dashboard</a> --}}
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline" style="border-color: var(--primary); color: var(--primary);">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

</body>
</html>
