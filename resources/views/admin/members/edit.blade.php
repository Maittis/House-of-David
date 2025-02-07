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
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $member->email) }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $member->phone) }}">
        </div>

        {{-- <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $member->address) }}</textarea>
        </div> --}}

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status">
                <option value="active" {{ $member->status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $member->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Add any other fields you wish to edit here -->

        <button type="submit" class="btn btn-primary">Update Member</button>
        <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
