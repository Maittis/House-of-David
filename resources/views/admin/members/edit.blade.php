@extends('layouts.app')

@section('content')
    <h1>Edit Member</h1>
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $member->name) }}" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="age" value="{{ old('age', $member->age) }}" min="0" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
        </div>

        <!-- Add any other fields you wish to edit here -->

        <button type="submit" class="btn btn-primary">Update Member</button>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
