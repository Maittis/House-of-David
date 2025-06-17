@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header with Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">
            <i class="fas fa-hand-holding-usd"></i> Donation Records
        </h1>
        <div>
            <a href="{{ route('donations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> New Donation
            </a>
            <a href="{{ route('donations.weekly-report') }}" class="btn btn-info">
                <i class="fas fa-calendar-week"></i> Weekly Report
            </a>
        </div>
    </div>

    <!-- QR Scanner Modal -->
    <div class="modal fade" id="qrScannerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-qrcode"></i> Scan Payment QR
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="qr-reader" style="width: 100%; min-height: 300px;"></div>
                    <p class="mt-3 text-muted">Scan member's payment confirmation QR code</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Donations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Recent Donations
                    </h6>
                </div>
                <div class="col-md-6 text-right">
                    <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#qrScannerModal">
                        <i class="fas fa-qrcode"></i> Quick Verify
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Receipt #</th>
                            <th>Member</th>
                            <th>Amount</th>
                            <th>Type</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $donation)
                        <tr>
                            <td>{{ $donation->receipt_number }}</td>
                            <td>{{ $donation->member->name ?? 'Guest' }}</td>
                            <td class="font-weight-bold">
                                @php
                                    $currencySymbols = [
                                        'ZMW' => 'ZK',
                                        'USD' => '$',
                                    ];
                                    $currencySymbol = $currencySymbols[$donation->currency] ?? '';
                                @endphp
                                {{ $currencySymbol }}{{ number_format($donation->amount, 2) }}
                            </td>
                            <td>
                                <span class="badge badge-{{
                                    $donation->type === 'tithe' ? 'primary' :
                                    ($donation->type === 'offering' ? 'success' : 'info')
                                }}">
                                    {{ ucfirst($donation->type) }}
                                </span>
                            </td>
                            <td>{{ ucfirst($donation->payment_method) }}</td>
                            <td>
                                <span class="badge badge-{{
                                    $donation->status === 'verified' ? 'success' : 'warning'
                                }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td>{{ $donation->created_at->format('M j, Y') }}</td>
                            <td>
                                <a href="{{ route('donations.show', $donation->id) }}"
                                   class="btn btn-sm btn-circle btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">No donations found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $donations->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    $(document).ready(function() {
        // QR Scanner
        $('#qrScannerModal').on('shown.bs.modal', function() {
            const scanner = new Html5QrcodeScanner('qr-reader', {
                fps: 10,
                qrbox: 250
            });

            scanner.render((txnId) => {
                fetch('/api/donations/verify-qr', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ transaction_id: txnId })
                }).then(response => {
                    if (response.ok) {
                        location.reload();
                    }
                });
                scanner.clear();
                $('#qrScannerModal').modal('hide');
            });
        });
    });
</script>
@endpush
@endsection
