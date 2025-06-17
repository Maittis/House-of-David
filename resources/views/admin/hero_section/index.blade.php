@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Manage Hero Section</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.hero-section.update') }}" method="POST" enctype="multipart/form-data" class="max-w-lg">
        @csrf

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Current Hero Image:</label>
            @if($heroSection && $heroSection->image_path)
                <img src="{{ asset('storage/' . $heroSection->image_path) }}" alt="Hero Image" class="w-full h-auto rounded shadow mb-4">
            @else
                <p>No hero image set.</p>
            @endif
        </div>

        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-semibold mb-2">Upload New Hero Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="border border-gray-300 rounded px-3 py-2 w-full">
            @error('image')
                <p class="text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Update Hero Image</button>
    </form>
</div>
@endsection
