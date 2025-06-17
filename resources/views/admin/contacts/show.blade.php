@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Contact Message Details</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>From: {{ $contact->name }}</h5>
                    <p>Email: {{ $contact->email }}</p>
                    <p>Subject: {{ $contact->subject }}</p>
                    <p>Date: {{ $contact->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h5>Message:</h5>
                    <p>{{ $contact->message }}</p>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
            <hr>
            <div class="row mt-4">
                <div class="col-12">
                    <h5>Reply to Contact</h5>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="reply_message">Message</label>
                            <textarea name="reply_message" id="reply_message" class="form-control" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
