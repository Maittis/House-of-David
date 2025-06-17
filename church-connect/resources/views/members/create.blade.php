<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Member - Church Connect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Add New Member</h1>
        <form action="{{ route('members.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block">Name</label>
                <input type="text" name="name" id="name" required class="w-full p-2 border rounded">
            </div>
            <div>
                <label for="email" class="block">Email</label>
                <input type="email" name="email" id="email" class="w-full p-2 border rounded">
            </div>
            <div>
                <label for="phone" class="block">Phone</label>
                <input type="text" name="phone" id="phone" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Member</button>
        </form>
        <a href="{{ route('dashboard') }}" class="mt-4 inline-block text-blue-500">Back to Dashboard</a>
    </div>
</body>
</html>
