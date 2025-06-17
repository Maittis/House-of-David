@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Events</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Create New Event</a>

    @if($events->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Start Date &amp; Time</th>
                    <th>End Date &amp; Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->description }}</td>
                    <td>{{ $event->start_datetime }}</td>
                    <td>{{ $event->end_datetime ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No events found.</p>
    @endif
</div>

<!-- Event Created Popup Modal -->
{{-- @if(session('success') && str_contains(session('success'), 'Event created successfully'))
<div id="eventCreatedModal" class="modal" style="display:none; position: fixed; z-index: 1050; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.5);">
    <div style="background-color: #fff; margin: 15% auto; padding: 20px; border-radius: 8px; width: 90%; max-width: 400px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,.5);">
        <h2>Event Created</h2>
        <p>{{ session('success') }}</p>
        <button id="closeEventModal" style="background-color: #007bff; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Close</button>
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
@endif --}}

@endsection
