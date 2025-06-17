@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contact Inquiries</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($contacts->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Submitted At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->subject }}</td>
                    <td>{{ $contact->message }}</td>
                    <td>{{ $contact->created_at->format('Y-m-d H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary btn-sm">Reply</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $contacts->links() }}
    @else
        <p>No contact inquiries found.</p>
    @endif
</div>
@endsection
