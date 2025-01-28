




@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-info text-white">
            <h2 class="mb-0">Follow Up Team - SMS Replies</h2>
        </div>
        <div class="card-body">
            @if ($replies->isEmpty())
                <div class="text-center text-muted py-5">
                    <i class="bi bi-chat-left-dots fs-1 mb-3"></i>
                    <p class="mb-0">No replies from members yet. Stay tuned!</p>
                </div>
            @else
                <table class="table table-striped table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>#</th>
                            <th>Member Name</th>
                            <th>Reply Message</th>
                            <th>Received At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($replies as $index => $reply)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $reply->member->name }}</td>
                                <td>{{ $reply->reply_message }}</td>
                                <td>{{ $reply->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal{{ $reply->id }}" title="Reply to Message">
                                        <i class="bi bi-reply"></i> Reply
                                    </button>

                                    <!-- Reply Modal -->
                                    <div class="modal fade" id="replyModal{{ $reply->id }}" tabindex="-1" aria-labelledby="replyModalLabel{{ $reply->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel{{ $reply->id }}">Send Follow-Up SMS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.followup.send', $reply->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="followup_message{{ $reply->id }}">Follow-Up Message:</label>
                                                            <textarea name="followup_message" id="followup_message{{ $reply->id }}" class="form-control" rows="4" placeholder="Enter your follow-up message..." required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Send SMS</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection




{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mb-5 shadow-sm">
        <div class="card-header bg-info text-white">
            <h2 class="mb-0">Follow Up Team - SMS Replies</h2>
        </div>
        <div class="card-body">
            @if ($replies->isEmpty())
                <p class="text-center text-muted">No replies from members yet.</p>
            @else
                <table class="table table-striped table-hover">
                    <thead class="table-info">
                        <tr>
                            <th>Member Name</th>
                            <th>Reply Message</th>
                            <th>Received At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($replies as $reply)
                            <tr>
                                <td>{{ $reply->member->name }}</td>
                                <td>{{ $reply->reply_message }}</td>
                                <td>{{ $reply->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal{{ $reply->id }}">
                                        Reply
                                    </button>

                                    <!-- Reply Modal -->
                                    <div class="modal fade" id="replyModal{{ $reply->id }}" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel">Send Follow-Up SMS</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.followup.send', $reply->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="followup_message">Follow-Up Message:</label>
                                                            <textarea name="followup_message" id="followup_message" class="form-control" rows="4" placeholder="Enter your follow-up message..." required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Send SMS</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection --}}
