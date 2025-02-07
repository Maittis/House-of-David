@extends('layouts.memberhouse')

@section('content')
<div class="container-fluid dashboard-container">
    <div class="col-md-4">
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
    </div>
</div>





       {{-- <!-- Display recent messages -->
       <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Recent Inspirational Messages</h5>
                    <ul class="list-group">
                        @foreach($inspirationalMessages as $message)
                            <li class="list-group-item">
                                <strong>{{ $message->created_at->format('d M Y') }}</strong>: {{ $message->content }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div> --}}


        <!-- Watch Services Section -->
        <div class="col-md-4 mb-4">
            <div class="card services-card">
                <div class="card-body">
                    <h3 class="card-title">Watch Services</h3>
                    <div class="service-content">
                        <img src="{{ asset('path/to/your/church-image.jpg') }}" alt="YourChurch" class="img-fluid mb-2">
                        <p>House of David Parish <span class="followers">1,186 followers</span></p>
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-primary btn-sm">Follow Page</a>
                            <a href="#" class="btn btn-secondary btn-sm">Share</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Make an Inquiry Section -->
        <div class="col-md-4 mb-4">
            <div class="card inquiry-card">
                <div class="card-body">
                    <h3 class="card-title">Make an Inquiry</h3>
                    <form action="{{ route('memberArea.inquiry.submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="4" placeholder="Type your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>





    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Your Inquiries</h3>
            </div>
            <div class="card-body">
                @if($inquiries->isNotEmpty())
                    <ul class="list-group list-group-flush">
                        @foreach($inquiries as $inquiry)
                            <li class="list-group-item">
                                <strong>Your Message:</strong> {{ $inquiry->message }}
                                <br>
                                @if($inquiry->reply)
                                    <strong>Admin Reply:</strong> {{ $inquiry->reply->reply }}
                                @else
                                    <em>No reply yet</em>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted text-center">You have no inquiries.</p>
                @endif
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row mt-2 justify-content-center">
            <div class="col-md-12 col-lg-6">
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
        </div>
    </div>

<style>
    .container {
        display: flex;
        justify-content: space-between;
        gap: 50px;
    }
    .card {
    margin: 25px; /* Adds space around each card */
    padding: 30px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
    .card h3 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 50px;
    }
    .card p {
        font-size: 1rem;
        color: #555;
    }
    .card iframe {
        width: 100%;
        border-radius: 8px;
    }
    textarea {
        width: 100%;
        height: 80px;
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
