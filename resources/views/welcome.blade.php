<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>House of David Parish</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Header Styling */
        .parish-header {
            background-image: linear-gradient(
                rgba(0, 0, 0, 0.6),
                rgba(0, 0, 0, 0.6)
            ), url('/images/house of david 4.jpg'); /* Replace with your image */
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
        }

        .post-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }

        .post-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a202c;
            transition: color 0.3s ease;
        }

        .post-title:hover {
            color: #e53e3e;
        }

        .pagination-link {
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            border-radius: 4px;
            color: white;
            background-color: #e53e3e;
            transition: all 0.3s ease;
        }

        .pagination-link:hover {
            background-color: #ff6b6b;
        }
    </style>
</head>
<body class="font-poppins bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
    <div class="min-h-screen">
        <!-- Navigation -->
        @if (Route::has('login'))
        <div class="p-6 text-right">
            @auth
            <a href="{{ url('/home') }}" class="text-lg font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Home</a>
            @else
            <a href="{{ route('login') }}" class="text-lg font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Log in</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-lg font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <!-- Header Section -->
        <div class="parish-header">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold">Welcome to House of David Parish</h1>
                <p class="mt-4 text-lg md:text-xl font-medium">"Transforming Lives Through Worship and Service"</p>
            </div>
        </div>

        <!-- Posts Section -->
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                <div class="post-card p-6">
                    <h2 class="post-title mb-2">{{ $post->title }}</h2>
                    <p class="text-sm text-gray-500 mb-4">{{ $post->created_at->format('F j, Y') }}</p>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        {{ substr($post->content, 0, 150) }}{{ strlen($post->content) > 150 ? '...' : '' }}
                    </p>
                    <a href="{{ route('post.show', $post->id) }}" class="text-red-500 font-semibold hover:text-red-700">Read More →</a>
                </div>
                @endforeach
            </div>




            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-gray-200 py-6 mt-12">
            <div class="container mx-auto text-center">
                <p>© {{ date('Y') }} House of David Parish. All rights reserved.</p>
                <p>Follow us on <a href="#" class="text-red-400 hover:text-red-600">Facebook</a> | <a href="#" class="text-red-400 hover:text-red-600">Instagram</a></p>
            </div>
        </footer>
    </div>
</body>
</html>
