<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contact Us - RCCG House of David</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 700px;
            margin: 3rem auto;
            background: white;
            padding: 2rem 3rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(139, 0, 0, 0.2);
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: #8B0000;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        label {
            font-weight: 600;
            margin-bottom: 0.3rem;
        }
        input[type="text"],
        input[type="email"],
        textarea {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            resize: vertical;
        }
        textarea {
            min-height: 120px;
        }
        button {
            background-color: #8B0000;
            color: white;
            font-weight: 600;
            padding: 0.9rem;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #6B0000;
        }
        .contact-info {
            margin-top: 2rem;
            text-align: center;
            font-size: 1rem;
            color: #555;
        }
        .contact-info p {
            margin: 0.3rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Us</h1>
        <form method="POST" action="/contact">
            @csrf
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Your full name" required />

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Your email address" required />

            <label for="subject">Subject</label>
            <input type="text" id="subject" name="subject" placeholder="Subject of your message" required />

            <label for="message">Message</label>
            <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
        <div class="contact-info">
            <p><strong>Address:</strong> 123 Church Street, Lusaka, Zambia</p>
            <p><strong>Phone:</strong> (+260) 123-456-7890</p>
            <p><strong>Email:</strong> info@rccghouseofdavidlusaka.org</p>
        </div>
    </div>




<!-- Back to Home Button -->
<div style="text-align: center; margin-top: 2rem;">
    <a href="/" style="
        display: inline-block;
        background-color: #8B0000;
        color: white;
        font-weight: 600;
        padding: 0.9rem 2rem;
        border: none;
        border-radius: 50px;
        text-decoration: none;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;">
        Back to Home
    </a>
</div>


</body>
</html>
