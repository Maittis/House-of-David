@extends('layouts.public')

@section('content')
<div class="container">
    <h1>Create Contact</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.contacts.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required>{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Create</button>
    </form>
</div>
@endsection
