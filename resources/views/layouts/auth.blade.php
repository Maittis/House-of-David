<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb); /* Gradient background for depth */
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .auth-container {
            width: 100%;
            max-width: 800px;
            padding: 2rem;
        }

        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .auth-card-header {
            background: linear-gradient(135deg, #3498db, #44ad8f);
            color: white;
            padding: 1rem;
            text-align: center;
        }

        .auth-card-header h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 50;
        }

        .auth-card-body {
            padding: 4.5rem;
        }

        .btn-primary {
            width: 100%;
            background: linear-gradient(135deg, #3498db, #44ad8f);
            border: none;
            border-radius: 12px;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9, #3a9a7a);
            transform: scale(1.02);
        }

        /* .card {
                max-height: 300px; /* Or whatever height fits your design */
                /* overflow-y: auto; /* Adds vertical scrollbar if content overflows */
                } */ */

                .card-text {
                    font-size: clamp(14px, 2vw, 18px); /* Adjust based on viewport width */
                    }


                    .card {
                        display: flex;
                        flex-direction: column;
                        }

                        .card-body {
                        flex: 1 1 auto; /* Allows body to grow with content */
                        }


                .card-text {
                display: -webkit-box;
                -webkit-line-clamp: 10; /* Number of lines to show */
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                }

        /* Responsive Design */
        @media (max-width: 768px) {
            .auth-container {
                padding: 1rem;
            }

            .auth-card-header {
                padding: 1.5rem;
            }

            .auth-card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">
                <h2 class="auth-title">@yield('auth-title')</h2>
            </div>
            <div class="auth-card-body">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
