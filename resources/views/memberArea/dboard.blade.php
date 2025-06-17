@extends('layouts.memberhouse')

@section('content')
<div class="dashboard-container">
    <div class="grid-container">
        <!-- Daily Inspiration Section -->
        <div class="card inspiration-card">
            <div class="card-body">
                <h5 class="card-title">Daily Inspiration</h5>
                @if(isset($inspirationalMessages) && $inspirationalMessages->isNotEmpty())
                    <p class="card-text text-muted small">{{ $inspirationalMessages->first()->content }}</p>
                    <p class="date-text small text-muted">{{ $inspirationalMessages->first()->created_at->format('Y-m-d') }}</p>
                @else
                    <p class="card-text text-muted small">No inspirational messages available.</p>
                @endif
            </div>
        </div>

        <!-- Attendance Marking Section -->
        <div class="card attendance-card">
            <div class="card-body">
                <h5 class="card-title">Mark Your Attendance</h5>
                <button id="markAttendanceBtn" class="btn btn-primary btn-sm">Mark Attendance</button>
                <p id="attendanceMessage" class="mt-2 small"></p>
            </div>
        </div>

        <!-- Watch Services Section -->
        <div class="card services-card">
            <div class="card-body">
                <h5 class="card-title">Watch Services</h5>
                <div class="service-content">
                    <div class="embed-responsive embed-responsive-16by9 mb-2">
                        <iframe
                            src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FRccgHouseOfDavidParishLusakaZambia%2Fvideos%2F&show_text=0&width=560"
                            width="100%"
                            height="200"
                            style="border:none;overflow:hidden"
                            scrolling="no"
                            frameborder="0"
                            allowTransparency="true"
                            allowFullScreen="true">
                        </iframe>
                    </div>
                    <p class="small">House of David Parish <span class="followers">1,186 followers</span></p>
                    <div class="d-flex justify-content-between">
                        <a href="https://web.facebook.com/Past332" class="btn btn-primary btn-sm">Follow Page</a>
                        <a href="#" class="btn btn-secondary btn-sm">Share</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inquiry Card -->
        <div class="card inquiry-card">
            <div class="card-header bg-primary text-white py-2">
                <h5 class="mb-0">Make an Inquiry</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('memberArea.inquiry.submit') }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <textarea name="message" class="form-control form-control-sm" rows="3" placeholder="Type your message here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">Submit</button>
                </form>
            </div>
        </div>

        <!-- Your Inquiries Section -->
        <div class="card inquiries-card">
            <div class="card-header bg-primary text-white py-2">
                <h5 class="mb-0">Your Inquiries</h5>
            </div>
            <div class="card-body chat-body p-2">
                @if($inquiries->isNotEmpty())
                    <div class="chat-messages">
                        @foreach($inquiries as $inquiry)
                            <div class="chat-item mb-2">
                                <div class="user-message bg-light p-2 rounded mb-1 small">
                                    <strong>You:</strong> {{ $inquiry->message }}
                                </div>
                                @if($inquiry->reply)
                                    <div class="admin-reply bg-info text-white p-2 rounded small">
                                        <strong>Admin:</strong> {{ $inquiry->reply->reply }}
                                    </div>
                                @else
                                    <div class="no-reply text-muted p-1 rounded small">
                                        <em>No reply yet</em>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="small">No inquiries found.</p>
                @endif
            </div>
        </div>

        <!-- Messages & Comments Section -->
        <div class="card messages-card">
            <div class="card-header py-2">
                <h5 class="mb-0">Messages & Comments</h5>
            </div>
            <div class="card-body p-2">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item p-2">
                        <p class="small mb-1">Welcome to our church community!</p>
                        <small class="text-muted">From: Admin on 2024-01-27</small>
                    </li>
                    <li class="list-group-item p-2">
                        <p class="small mb-1">Join us this Sunday for a special service.</p>
                        <small class="text-muted">From: Admin on 2024-01-26</small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    .dashboard-container {
        padding: 1rem;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .card-header {
        padding: 0.5rem 1rem;
    }

    .card-body {
        padding: 1rem;
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .small {
        font-size: 0.85rem;
    }

    .chat-body {
        max-height: 300px;
        overflow-y: auto;
        padding: 0.5rem;
    }

    .user-message, .admin-reply, .no-reply {
        border-radius: 12px;
        max-width: 80%;
        padding: 0.5rem;
        margin-bottom: 0.3rem;
    }

    textarea.form-control-sm {
        min-height: calc(1.5em + 0.75rem + 2px);
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>

<script>
document.getElementById('markAttendanceBtn').addEventListener('click', function() {
    var messageEl = document.getElementById('attendanceMessage');
    if (!navigator.geolocation) {
        messageEl.textContent = 'Geolocation is not supported by your browser.';
        return;
    }

    messageEl.textContent = 'Checking location...';

    navigator.geolocation.getCurrentPosition(function(position) {
        fetch('{{ route('member.attendance.mark') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                messageEl.textContent = data.message;
            } else if (data.error) {
                messageEl.textContent = data.error;
            } else {
                messageEl.textContent = 'Unexpected response from server.';
            }
        })
        .catch(error => {
            messageEl.textContent = 'Error marking attendance: ' + error;
        });
    }, function() {
        messageEl.textContent = 'Location access denied. Please enable location to mark attendance.';
    });
});
</script>
@endsection