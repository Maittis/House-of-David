@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-5">

                    <h2 class="text-center text-primary mb-4">Make a Donation</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('donations.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="guest_email" class="form-label">Email <small class="text-muted">(optional, for receipt)</small></label>
                            <input type="email" name="guest_email" id="guest_email" class="form-control rounded-pill" value="{{ old('guest_email') }}" placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" min="1" step="0.01" name="amount" id="amount" class="form-control rounded-pill" value="{{ old('amount') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="currency" class="form-label">Currency</label>
                            <select name="currency" id="currency" class="form-select rounded-pill" required>
                                <option value="ZMW" {{ old('currency') == 'ZMW' ? 'selected' : '' }}>Zambian Kwacha (ZMW)</option>
                                <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>US Dollar (USD)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select rounded-pill" required>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Direct Bank Transfer</option>
                                <option value="mobile" {{ old('payment_method') == 'mobile' ? 'selected' : '' }}>Mobile Transfer</option>
                                <option value="qr" {{ old('payment_method') == 'qr' ? 'selected' : '' }}>QR Code</option>
                            </select>
                        </div>

                        <div id="payment-instructions" class="mb-4 bg-light border border-primary-subtle p-4 rounded-3 shadow-sm" style="display:none;">
                            <h5 class="mb-3 text-primary">Payment Instructions</h5>
                            <div id="cash-instructions" style="display:none;">
                                <p class="mb-0">Please pay the amount in cash at the church office.</p>
                            </div>
                            <div id="bank-instructions" style="display:none;">
                                <p>Please transfer the amount to the following bank account:</p>
                                <ul>
                                    <li><strong>Bank:</strong> XYZ Bank</li>
                                    <li><strong>Account Name:</strong> RCCG House of David</li>
                                    <li><strong>Account Number:</strong> 1234567890</li>
                                    <li><strong>Branch:</strong> Lusaka</li>
                                </ul>
                            </div>
                            <div id="mobile-instructions" style="display:none;">
                                <p>Please send the amount via mobile money to:</p>
                                <ul>
                                    <li><strong>Mobile Number:</strong> +260 123 456 789</li>
                                    <li><strong>Account Name:</strong> RCCG House of David</li>
                                </ul>
                            </div>
                            <div id="qr-instructions" style="display:none;" class="text-center">
                                <p>Please scan the following QR code to make your payment:</p>
                                <img src="{{ asset('images/qr.png') }}" alt="Payment QR Code" class="img-fluid rounded shadow-sm" style="max-width: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Donation Type</label>
                            <select name="type" id="type" class="form-select rounded-pill" required>
                                <option value="donation" {{ old('type') == 'donation' ? 'selected' : '' }}>General Donation</option>
                                <option value="tithe" {{ old('type') == 'tithe' ? 'selected' : '' }}>Tithe</option>
                                <option value="offering" {{ old('type') == 'offering' ? 'selected' : '' }}>Offering</option>
                                <option value="project" {{ old('type') == 'project' ? 'selected' : '' }}>Project</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="transaction_id" class="form-label">Transaction ID <small class="text-muted">(if applicable)</small></label>
                            <input type="text" name="transaction_id" id="transaction_id" class="form-control rounded-pill" value="{{ old('transaction_id') }}">
                            <small class="form-text text-muted">Enter your transaction ID if you used bank or mobile transfer.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Submit Donation</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethodSelect = document.getElementById('payment_method');
            const instructionsDiv = document.getElementById('payment-instructions');
            const cashInstructions = document.getElementById('cash-instructions');
            const bankInstructions = document.getElementById('bank-instructions');
            const mobileInstructions = document.getElementById('mobile-instructions');
            const qrInstructions = document.getElementById('qr-instructions');

            function updateInstructions() {
                const selected = paymentMethodSelect.value;
                instructionsDiv.style.display = 'block';
                cashInstructions.style.display = 'none';
                bankInstructions.style.display = 'none';
                mobileInstructions.style.display = 'none';
                qrInstructions.style.display = 'none';

                if (selected === 'cash') {
                    cashInstructions.style.display = 'block';
                } else if (selected === 'bank') {
                    bankInstructions.style.display = 'block';
                } else if (selected === 'mobile') {
                    mobileInstructions.style.display = 'block';
                } else if (selected === 'qr') {
                    qrInstructions.style.display = 'block';
                } else {
                    instructionsDiv.style.display = 'none';
                }
            }

            paymentMethodSelect.addEventListener('change', updateInstructions);

            updateInstructions(); // Initialize on load
        });
    </script>
</div>
@endsection
