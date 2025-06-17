@extends('layouts.welcome')

@section('content')
<div class="container mt-4">
    <h1>{{ $event->title }}</h1>

    @if($event->image_path)
        <div class="text-center">
            <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="img-fluid mb-3" style="max-height: 400px;">
        </div>
    @endif

    <p><strong>Start:</strong> {{ \Carbon\Carbon::parse($event->start_datetime)->format('F j, Y, g:i a') }}</p>

    @if($event->end_datetime)
        <p><strong>End:</strong> {{ \Carbon\Carbon::parse($event->end_datetime)->format('F j, Y, g:i a') }}</p>
    @endif

    <div>
        {!! nl2br(e($event->description)) !!}
    </div>

    {{-- <a href="{{ route('/home') }}" class="btn btn-primary mt-3">Back to Events</a> --}}
</div>
<style>
    <style>
    .event-image {
        display: block;
        margin: 0 auto;
        max-height: 400px;
    }
</style>

</style>
@endsection

