<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Collections - Usher</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6a4c93;
            --secondary: #8ac926;
            --accent: #1982c4;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #38b000;
            --warning: #ffca3a;
            --error: #ff595e;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            color: var(--dark);
            background-color: #f5f7ff;
            margin: 0;
            padding: 0;
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 100;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            margin: 0;
            font-size: 2.2rem;
            text-align: center;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary);
            margin-top: 0;
            font-size: 1.8rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--secondary);
            border-radius: 2px;
        }

        nav {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        nav a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        section {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        section:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        form {
            display: grid;
            gap: 1.5rem;
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: 600;
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        input, select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(25, 130, 196, 0.2);
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #5a3d7d;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #clear-signature-btn {
            background-color: var(--warning);
            color: var(--dark);
        }

        #clear-signature-btn:hover {
            background-color: #e6b800;
        }

        #signature-pad {
            border: 2px solid #e9ecef;
            border-radius: 6px;
            background-color: white;
            cursor: crosshair;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        th {
            background-color: var(--primary);
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        #public-collection-message,
        #usher-login-message,
        #usher-collection-message,
        #admin-login-message,
        #admin-report-message {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 6px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            main {
                padding: 0 1rem;
            }

            section {
                padding: 1.5rem;
            }

            form {
                gap: 1rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Church Collections - Usher</h1>
        <nav>
            <a href="http://127.0.0.1:8000/" id="nav-home">Home</a>
            <a href="#" id="nav-collections">Collections</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
