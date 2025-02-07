@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>New Members (Last Month)</h4>
        </div>
        <div class="card-body">
            @if ($newMembers->isEmpty())
                <p>No new members in the last month.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newMembers as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.send-welcome-message', $member->id) }}" class="btn btn-sm btn-success">Send Welcome</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
