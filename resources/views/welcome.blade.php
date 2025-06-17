    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RCCG HOUSE OF DAVID</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        :root {
            --primary: #8B0000; /* Darker, more elegant red */
            --primary-light: rgba(139, 0, 0, 0.1);
            --secondary: #333333;
            --accent: #D4AF37; /* Gold accent */
            --light: #F9F9F9;
            --dark: #1A1A1A;
            --text: rgb(0, 0, 0)0, 0);
            --text-light: #fffafa;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.16);
            --border-radius: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.7;
            color: var(--text);
            background: var(--light);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: var(--dark);
            line-height: 1.3;
        }

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

        /* Hero Section */
        .hero-section {
            position: relative;
            height: 90vh;
            min-height: 700px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6));
            z-index: 1;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            animation: zoomEffect 20s infinite alternate;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 800px;
            padding: 0 2rem;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            animation: fadeInUp 1s ease-out 0.2s forwards;
            opacity: 0;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            animation: fadeInUp 1s ease-out 0.4s forwards;
            opacity: 0;
        }

        /* Sections */
        .section {
            padding: 6rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
            position: relative;
        }

        .section-title h2 {
            font-size: 2.5rem;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--primary);
            margin: 1.5rem auto 0;
        }

        /* Cards */
        .card-grid {
            display: grid;
            gap: 2rem;
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
        }

        .card {
            background: transparent;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.1);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
        }

        .event-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .event-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .event-card-content {
            padding: 2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .event-date {
            display: inline-block;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .testimonial-card {
            padding: 2.5rem;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .testimonial-card::before {
            content: "❝";
            position: absolute;
            top: 1rem;
            left: 1.5rem;
            font-size: 5rem;
            color: var(--primary);
            opacity: 0.1;
            z-index: 0;
            font-family: 'Playfair Display', serif;
        }

        .testimonial-content {
            position: relative;
            z-index: 1;
        }

        .testimonial-rating {
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-author img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-author-info h4 {
            margin-bottom: 0.2rem;
        }

        .testimonial-author-info p {
            font-size: 0.9rem;
            color: var(--text-light);
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
        }

        .btn-primary:hover {
            background: #6B0000;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(139, 0, 0, 0.3);
        }

        .btn-outline {
            border: 2px solid white;
            color: white;
            background: transparent;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .btn-link {
            color: var(--primary);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
        }

        .btn-link:hover {
            color: #6B0000;
            gap: 0.7rem;
        }

        /* Footer */
        footer {
            background: var(--dark);
            color: white;
            padding: 6rem 2rem 3rem;
            position: relative;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 4rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-logo {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
            font-family: 'Playfair Display', serif;
        }

        .footer-about p {
            opacity: 0.7;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .footer-links h3, .footer-contact h3 {
            font-size: 1.4rem;
            margin-bottom: 2rem;
            position: relative;
            font-family: 'Playfair Display', serif;
        }

        .footer-links h3::after, .footer-contact h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -0.5rem;
            width: 50px;
            height: 2px;
            background: var(--primary);
        }

        .footer-links ul {
            display: grid;
            gap: 1rem;
        }

        .footer-links a {
            opacity: 0.7;
            transition: var(--transition);
            color: white;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--accent);
            padding-left: 8px;
        }

        .contact-info {
            display: grid;
            gap: 1.5rem;
        }

        .contact-item {
            display: flex;
            gap: 1.2rem;
            align-items: flex-start;
        }

        .contact-icon {
            color: var(--accent);
            font-size: 1.2rem;
            margin-top: 0.2rem;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            transition: var(--transition);
            color: white;
        }

        .social-links a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 3rem;
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            opacity: 0.6;
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes zoomEffect {
            0% { transform: scale(1); }
            100% { transform: scale(1.1); }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-content h1 {
                font-size: 2.8rem;
            }

            .section {
                padding: 5rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 1.5rem;
                padding: 1.5rem;
            }

            .nav-links {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .hero-section {
                height: auto;
                min-height: 600px;
                padding: 6rem 1rem;
            }

            .hero-content h1 {
                font-size: 2.2rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .grid-2, .grid-3 {
                grid-template-columns: 1fr;
            }

            .section-title h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 1.8rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .btn {
                padding: 0.8rem 1.5rem;
                font-size: 0.9rem;
            }
        }

        .date-time-display {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 3;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            padding: 10px 15px;
            border-radius: var(--border-radius);
            font-family: 'Poppins', sans-serif;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        #current-date {
            font-size: 1rem;
            font-weight: 500;
        }

        #current-time {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .event-card img {
            width: 100%;
            height: 250px; /* You can adjust this to 280px, 300px, etc. as needed */
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }


    </style>
</head>
<body>
    <!-- Navigation -->
    <nav id="navbar">
        <div class="nav-container">
            <a href="/" class="logo-link">
                <img
                    src="{{ asset('images/logo1.png') }}"
                    alt="St Columba's Logo"
                    class="logo"
                >
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

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-bg">
            @php
                use App\Models\HeroSection;
                $heroSection = HeroSection::first();
                $heroImage = $heroSection && $heroSection->image_path ? asset('storage/' . $heroSection->image_path) : asset('images/built.jpg');
            @endphp
            <img src="{{ $heroImage }}" alt="St Columba's Church">
        </div>
            <div class="date-time-display">
                <div id="current-date"></div>
                <div id="current-time"></div>
            </div>
        <div class="hero-content">
            <h1>Welcome to RCCG House of David Lusaka, Zambia</h1>
            <p>A community of faith, hope, and love serving God in Lusaka since 1952</p>
            <div class="hero-buttons">
                <a href="/about" class="btn btn-primary">Learn More</a>
                <a href="/contact" class="btn btn-outline">Contact Us</a>
                {{-- <a href="/donations" class="btn btn-outline">Donate Now</a> --}}
            </div>
        </div>
        <script>
                        // Time and date display
            function updateDateTime() {
                const now = new Date();

                // Format date (e.g., "Friday, June 9, 2023")
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);

                // Format time (e.g., "11:45 AM")
                let hours = now.getHours();
                const minutes = now.getMinutes().toString().padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'

                document.getElementById('current-time').textContent = `${hours}:${minutes} ${ampm}`;
            }

            // Update immediately and then every minute
            updateDateTime();
            setInterval(updateDateTime, 60000);
        </script>
    </section>

<!-- Upcoming Events -->
<section class="section">
    <div class="section-title text-center mb-5">
        <h2 class="fw-bold">Upcoming Events</h2>
    </div>

    <style>
        .event-card {
            display: flex;
            flex-direction: column;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
            background-color: #fff;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .event-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .event-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .event-card-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .event-date {
            display: inline-block;
            background-color: #6366f1;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            margin-bottom: 0.75rem;
        }

        .event-card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: #111827;
        }

        .event-card p.text-light {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .event-card .btn-link {
            margin-top: auto;
            font-weight: 500;
            color: #4f46e5;
            text-decoration: none;
        }

        .event-card .btn-link i {
            margin-left: 0.3rem;
        }

        .card-grid.grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
    </style>

    <div class="card-grid grid-3">
        @foreach ($events as $event)
        <div class="card event-card">
            @if($event->image_path)
                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
            @else
                <img src="{{ asset('images/events/default.jpg') }}" alt="{{ $event->title }}">
            @endif
            <div class="event-card-content">
                <span class="event-date">{{ $event->start_datetime->format('M d') }}</span>
                <h3>{{ $event->title }}</h3>
                <p class="text-light">{{ $event->start_datetime->format('g:i A') }} - {{ $event->end_datetime ? $event->end_datetime->format('g:i A') : '' }}</p>
                <p class="mb-4">{{ Str::limit($event->description, 100) }}</p>
                <a href="{{ route('events.show', $event->slug) }}" class="btn-link">
                    Read More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>



    <!-- Testimonies Section -->
    <section class="section" style="background: var(--light);">
        <div class="section-title">
            <h2>Testimonies</h2>
        </div>
        <div class="card-grid grid-3">
            @foreach ($testimonials as $testimonial)
            <div class="card testimonial-card">
                <div class="testimonial-content">
                    <div class="testimonial-rating">
                        @for ($i = 0; $i < $testimonial->rating; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        @if ($testimonial->rating < 5)
                            @for ($i = $testimonial->rating; $i < 5; $i++)
                                <i class="far fa-star"></i>
                            @endfor
                        @endif
                    </div>
                    <p class="testimonial-text">{{ $testimonial->text }}</p>
                    <div class="testimonial-author">
                        @if ($testimonial->author_image)
                            <img src="{{ asset('storage/' . $testimonial->author_image) }}" alt="{{ $testimonial->author_name }}">
                        @else
                            <img src="https://randomuser.me/api/portraits/lego/1.jpg" alt="{{ $testimonial->author_name }}">
                        @endif
                        <div class="testimonial-author-info">
                            <h4>{{ $testimonial->author_name }}</h4>
                            <p>Member since {{ $testimonial->created_at->format('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Latest Sermons -->
    <section class="section">
        <div class="section-title">
            <h2>Latest Sermons</h2>
        </div>
        <div class="card-grid grid-2">
            @foreach ($sermons as $sermon)
            <div class="card">
                <div class="flex justify-center items-center mx-auto" style="height: 250px; background: rgba(139, 0, 0, 0.05); border-radius: var(--border-radius); overflow: hidden;">
                    @if($sermon->video_url)
                        <iframe
                            width="800"
                            height="350"
                            src="https://www.youtube-nocookie.com/embed/{{ $sermon->youtube_id }}?rel=0"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    @elseif($sermon->image_path)
                        <img src="{{ asset('storage/' . $sermon->image_path) }}" alt="{{ $sermon->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-bible text-5xl text-gray-200"></i>
                        </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3>{{ $sermon->title }}</h3>
                    <p class="text-light mt-2">{{ $sermon->created_at->format('F j, Y') }}</p>
                    @if($sermon->content)
                        <p class="mt-4 text-light">{{ Str::limit($sermon->content, 150) }}</p>
                    @endif
                    {{-- <div class="mt-6">
                        @if($sermon->video_url)
                            <a href="{{ $sermon->video_url }}" target="_blank" class="btn btn-primary">
                                Watch on YouTube <i class="fas fa-external-link-alt ml-2"></i>
                            </a>
                        @endif
                    </div> --}}
                </div>
            </div>
            @endforeach
        </div>
        {{-- <div class="text-center mt-8">
            <a href="/sermons" class="btn-link">
                View All Sermons <i class="fas fa-arrow-right"></i>
            </a>
        </div> --}}
    </section>

  <!-- Order of Worship and Pastor's Devotions Section -->
<section class="section" style="background: var(--light);">
    <div class="section-title">
        <h2>Order of Worship & Pastor's Devotions</h2>
    </div>
        <div class="card-grid grid-2">
            @if($orderOfWorship)
            <div class="card">
                @if($orderOfWorship->image_path)
                    <img src="{{ asset('storage/' . $orderOfWorship->image_path) }}" alt="{{ $orderOfWorship->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h3>{{ $orderOfWorship->title }}</h3>
                    <div>{!! nl2br(e($orderOfWorship->content)) !!}</div>
                </div>
            </div>
            @endif
            @if($pastorDevotion)
            <div class="card">
                @if($pastorDevotion->image_path)
                    <img src="{{ asset('storage/' . $pastorDevotion->image_path) }}" alt="{{ $pastorDevotion->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-6">
                    <h3>{{ $pastorDevotion->title }}</h3>
                    <div>{!! nl2br(e($pastorDevotion->content)) !!}</div>
                    @if($pastorDevotion->video_url)
                        <div class="mt-4 aspect-w-16 aspect-h-9">
                            <iframe
                                src="https://www.youtube-nocookie.com/embed/{{ \Illuminate\Support\Str::after($pastorDevotion->video_url, 'v=') }}?rel=0"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="w-full h-full"
                                loading="lazy">
                            </iframe>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
</section>


    <!-- Call to Action -->
    <section class="section" style="background: var(--primary); color: white; text-align: center;">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="color: white; margin-bottom: 1.5rem;">Join Us This Sunday</h2>
            <p style="font-size: 1.2rem; opacity: 0.9; margin-bottom: 2.5rem;">We'd love to welcome you to our worship service. Experience the warmth of our community and the power of God's word.</p>
            <div style="display: flex; gap: 1.5rem; justify-content: center;">
                <a href="/services" class="btn btn-outline">Service Times</a>
                <a href="/contact" class="btn" style="background: white; color: var(--primary);">Get Directions</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-about">
                <div class="footer-logo">RCCG House of David Lusaka, Zambia</div>
                <p>Founded in 1952, we are a vibrant Christian community committed to serving God and our neighbors in Lusaka and beyond.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/sermons">Sermons</a></li>
                    <li><a href="/events">Events</a></li>
                    <li><a href="/blog">Blog</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt contact-icon"></i>
                        <span>123 Church Street, Lusaka, Zambia</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-phone contact-icon"></i>
                        <span>(+260) 123-456-7890</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope contact-icon"></i>
                        <span>info@rccghouseofdavidlusaka.org</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-clock contact-icon"></i>
                        <span>Sunday Services: 8:00 AM & 10:30 AM</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright">
            © {{ date('Y') }} RCCG House of David. All Rights Reserved.
        </div>
    </footer>

    <!-- Event Created Popup Modal -->
    @if(session('success') && str_contains(session('success'), 'Event created successfully'))
    <div id="eventCreatedModal" class="modal" style="display:none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
        <div style="background-color: #fff; margin: 15% auto; padding: 20px; border-radius: 8px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,.5);">
            <h2>Event Created</h2>
            <p>{{ session('success') }}</p>
            <button id="closeEventModal" style="background-color: var(--primary); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Close</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('eventCreatedModal');
            var closeBtn = document.getElementById('closeEventModal');

            modal.style.display = 'block';

            closeBtn.onclick = function() {
                modal.style.display = 'none';
            };

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });
    </script>
    @endif

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Animation on scroll
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.card, .section-title');
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;

                if (elementPosition < screenPosition) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        };

        // Set initial state for animated elements
        document.querySelectorAll('.card, .section-title').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        });

        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);
    </script>
</body>
</html>
