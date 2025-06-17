@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt"></i> Donation Receipt: {{ $donation->receipt_number }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="receipt-details">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Member</h6>
                                <p class="font-weight-bold">{{ $donation->member->name ?? 'Guest' }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <h6 class="text-muted">Date</h6>
                                <p>{{ $donation->created_at->format('M j, Y \a\t h:i A') }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Amount</h6>
                                <p class="display-4 text-primary">ZMW{{ number_format($donation->amount, 2) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Type</h6>
                                <p>
                                    <span class="badge badge-{{
                                        $donation->type === 'tithe' ? 'primary' :
                                        ($donation->type === 'offering' ? 'success' : 'info')
                                    }}">
                                        {{ ucfirst($donation->type) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Payment Method</h6>
                                <p>{{ ucfirst($donation->payment_method) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Status</h6>
                                <p>
                                    <span class="badge badge-{{
                                        $donation->status === 'verified' ? 'success' : 'warning'
                                    }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        @if($donation->transaction_id)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="text-muted">Transaction Reference</h6>
                                <p class="font-monospace">{{ $donation->transaction_id }}</p>
                            </div>
                        </div>
                        @endif

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-muted">Recorded By</h6>
                                <p>{{ $donation->recorder->name ?? 'System' }}</p>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#" class="btn btn-outline-primary">
                                    <i class="fas fa-print"></i> Print Receipt
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
