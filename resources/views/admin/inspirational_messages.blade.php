<!-- resources/views/admin/inspirational_messages.blade.php -->
@extends('layouts.app')

@section('content')





<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Send Inspirational Message</h5>
                <form action="{{ route('admin.send-inspiration') }}" method="POST" id="inspirationForm">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Write your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/admin/get-latest-inspiration')
    .then(response => {
        console.log('Response status:', response.status);
        return response.json();
    })
    .then(data => {
        console.log('Fetched data:', data);
        document.getElementById('inspiration-content').textContent = data.content || 'No messages yet';
        document.getElementById('inspiration-date').textContent = data.date || '';
    })
    .catch(error => console.error('Error fetching inspiration:', error));
});

@endsection
