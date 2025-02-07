@extends('layouts.app')

@section('title', 'Inquiries')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Inquiries</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Message</th>
                <th>Date</th>
                <th>Reply</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inquiries as $inquiry)
                <tr>
                    <td>{{ $inquiry->message }}</td>
                    <td>{{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.replyInquiry', $inquiry->id) }}" method="POST">
                            @csrf
                            <input type="text" name="reply" class="form-control @error('reply') is-invalid @enderror" placeholder="Type your reply">
                            @error('reply')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary btn-sm mt-2">Send Reply</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No inquiries available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

