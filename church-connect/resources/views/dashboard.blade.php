<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Connect - Dashboard</title>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}">
    <script type="module" src="{{ Vite::asset('resources/js/app.js') }}"></script>

</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white p-4">
            <h1 class="text-xl font-semibold mb-6">Church Connect</h1>
            <nav>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Members</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Attendance</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Messages</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Reports</a>
                <a href="#" class="block py-2 px-4 hover:bg-gray-700">Settings</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Members -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-gray-500 text-sm">Total Members</h2>
                    <p class="text-2xl font-bold">{{ $totalMembers }}</p>
                    <span class="text-green-500">↑ 5% this month</span>
                </div>

                <!-- Present Today -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-gray-500 text-sm">Present Today</h2>
                    <p class="text-2xl font-bold">{{ $presentToday }}</p>
                    <span class="text-gray-500">70% attendance</span>
                </div>

                <!-- Absent Members -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-gray-500 text-sm">Absent Members</h2>
                    <p class="text-2xl font-bold">{{ $absentMembers }}</p>
                    <span class="text-yellow-500">Needs follow-up</span>
                </div>

                <!-- New Members -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h2 class="text-gray-500 text-sm">New Members</h2>
                    <p class="text-2xl font-bold">{{ $newMembers }}</p>
                    <span class="text-gray-500">This month</span>
                </div>
            </div>

            <!-- Member Management Section -->
            <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold">Member Management</h2>
                <a href="{{ route('members.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">+ Add Member</a>
            </div>

            <!-- Member List -->
            <div class="bg-white p-4 rounded-lg shadow">
                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left">Name</th>
                            <th class="text-left">Phone</th>
                            <th class="text-left">Last Attendance</th>
                            <th class="text-left">Status</th>
                            <th class="text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>{{ $member->last_attendance }}</td>
                            <td><span class="bg-green-500 text-white px-2 py-1 rounded">Active</span></td>
                            <td>
                                <a href="{{ route('members.edit', $member->id) }}" class="text-blue-500 mr-2">✏️</a>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Follow-up Needed -->
            <div class="bg-white p-4 rounded-lg shadow mt-6">
                <h2 class="text-xl font-semibold mb-4">Follow-up Needed</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p>Sarah Johnson</p>
                        <p class="text-gray-500">Last attended: 3 weeks ago</p>
                    </div>
                    <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded">Contact</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
