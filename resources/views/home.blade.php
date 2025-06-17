{{-- @extends('layouts.public')

@section('content')
<div class="container text-center my-5">
    <h1>Welcome to Our Church Attendance Tracker</h1>
    <p class="lead">Quick access to key sections:</p>
    <div class="row justify-content-center mt-4">
        <div class="col-md-3 mb-3">
            <a href="{{ url('/') }}" class="btn btn-primary btn-block py-3">
                Visit Welcome Page
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('donations.create') }}" class="btn btn-success btn-block py-3">
                Make a Donation
            </a>
        </div>
        @if(auth()->check() && auth()->user()->hasRole('admin'))
        <div class="col-md-3 mb-3">
            <a href="{{ route('donations.index') }}" class="btn btn-info btn-block py-3">
                View Donations
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-block py-3">
                Admin Dashboard
            </a>
        </div>
        @endif
    </div>
</div>
@endsection --}}
