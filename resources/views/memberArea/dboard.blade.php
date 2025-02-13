@extends('layouts.memberhouse')

@section('content')
<div class="dashboard-container">
    <div class="grid-container">
        <!-- Daily Inspiration Section -->
        <div class="card inspiration-card">
            <div class="card-body">
                <h3 class="card-title">Daily Inspiration</h3>
                @if(isset($inspirationalMessages) && $inspirationalMessages->isNotEmpty())
                    <p class="card-text text-muted">{{ $inspirationalMessages->first()->content }}</p>
                    <p class="date-text">{{ $inspirationalMessages->first()->created_at->format('Y-m-d') }}</p>
                @else
                    <p class="card-text text-muted">No inspirational messages available.</p>
                @endif
            </div>
        </div>

        <!-- Watch Services Section -->
        <div class="card services-card">
            <div class="card-body">
                <h3 class="card-title">Watch Services</h3>
                <div class="service-content">
                    <!-- Facebook Video Embed -->
                    <div class="embed-responsive embed-responsive-16by9 mb-3">
                        <iframe
                            src="https://www.facebook.com/plugins/video.php?href=https%3A%2F%2Fwww.facebook.com%2FRccgHouseOfDavidParishLusakaZambia%2Fvideos%2F&show_text=0&width=560"
                            width="100%"
                            height="315"
                            style="border:none;overflow:hidden"
                            scrolling="no"
                            frameborder="0"
                            allowTransparency="true"
                            allowFullScreen="true">
                        </iframe>
                    </div>

                    <p>House of David Parish <span class="followers">1,186 followers</span></p>
                    <div class="d-flex justify-content-between">
                        <a href="https://web.facebook.com/Past332" class="btn btn-primary btn-sm">Follow Page</a>
                        <a href="#" class="btn btn-secondary btn-sm">Share</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card inquiry-and-your-inquiries-card">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">Inquiries</h3>
            </div>
            <div class="card-body">
                <!-- Make an Inquiry Section -->
                <div class="make-inquiry-section mb-4">
                    <h4 class="card-title">Make an Inquiry</h4>
                    <form action="{{ route('memberArea.inquiry.submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="4" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>

               <!-- Your Inquiries Section -->
<div class="card inquiries-card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Your Inquiries</h3>
    </div>
    <div class="card-body chat-body">
        @if($inquiries->isNotEmpty())
            <div class="chat-messages">
                @foreach($inquiries as $inquiry)
                    <div class="chat-item mb-3">
                        <div class="user-message bg-light p-2 rounded mb-2">
                            <strong>You:</strong> {{ $inquiry->message }}
                        </div>
                        @if($inquiry->reply)
                            <div class="admin-reply bg-info text-white p-2 rounded">
                                <strong>Admin:</strong> {{ $inquiry->reply->reply }}
                            </div>
                        @else
                            <div class="no-reply text-muted p-2 rounded">
                                <em>No reply yet</em>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            @else
            <p>No inquiries found.</p>
        @endif
    </div>
</div>

    <!-- Messages & Comments Section -->
    <div class="card messages-card">
        <div class="card-header">
            <h3 class="mb-0">Messages & Comments</h3>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <p>Welcome to our church community!</p>
                    <small>From: Admin on 2024-01-27</small>
                    <form class="reply-form">
                        <textarea class="form-control" rows="2" placeholder="Reply to this message..."></textarea>
                    </form>
                </li>
                <li class="list-group-item">
                    <p>Join us this Sunday for a special service.</p>
                    <small>From: Admin on 2024-01-26</small>
                    <form class="reply-form">
                        <textarea class="form-control" rows="2" placeholder="Reply to this message..."></textarea>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<style>
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        padding: 2rem;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .card-text {
        font-size: 1rem;
        color: #555;
    }

    .chat-body {
        background-color: #f8f9fa;
        min-height: 300px;
        overflow-y: auto;
    }

    .chat-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .user-message, .admin-reply, .no-reply {
        border-radius: 15px;
        max-width: 70%;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }

    .user-message {
        background-color: #e9ecef;
        align-self: flex-start;
    }

    .admin-reply {
        background-color: #17a2b8;
        color: white;
        align-self: flex-end;
    }

    .no-reply {
        background-color: #f8f9fa;
        color: #6c757d;
        align-self: center;
    }

    textarea {
        width: 100%;
        border-radius: 6px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    button {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background: #218838;
    }
</style>
@endsection
