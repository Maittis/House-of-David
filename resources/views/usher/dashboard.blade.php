@extends('layouts.usher')

@section('content')
<div class="container">
    <h1>Usher Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}! This is the usher dashboard.</p>

    <section id="usher-collection">
        <h2>Collection Entry</h2>

        <div>
            <label for="usher-name">Enter Your Name:</label>
            <input type="text" id="usher-name" placeholder="Enter your name" value="{{ auth()->user()->name }}" />
        </div>
        <div>
            <label for="payer-name">Enter Payer Name:</label>
            <input type="text" id="payer-name" placeholder="Enter name of the person paying" />
        </div>
        <div>
            <label for="collection-type">Select Collection Type:</label>
            <select id="collection-type">
                <option value="offering">Offering</option>
                <option value="tithe">Tithe</option>
                <option value="donation">Donation</option>
            </select>
        </div>

        <div>
            <label for="amount-collected">Enter Amount Collected:</label>
            <input type="number" id="amount-collected" min="0" step="0.01" placeholder="Enter amount" />
        </div>

        <div>
            <label>Signature:</label>
            <canvas id="signature-pad" width="400" height="150" style="border:1px solid #000;"></canvas>
            <br />
            <button id="clear-signature">Clear Signature</button>
        </div>

        <button id="submit-collection">Submit Collection</button>

        <div id="message" style="margin-top: 10px; color: green;"></div>
    </section>

    <!-- Summary Section -->
    <section id="collection-summary" style="margin-top: 3rem;">
        <h2>Collection Summary</h2>
        @foreach ($usherSummaries as $usherName => $summary)
            <div style="margin-bottom: 1rem; border-bottom: 1px solid #ccc; padding-bottom: 0.5rem;">
                <p><strong>Name:</strong> {{ $usherName }}</p>
                <p><strong>Total Tithe:</strong> {{ number_format($summary['tithe'] ?? 0, 2) }}</p>
                <p><strong>Total Offering:</strong> {{ number_format($summary['offering'] ?? 0, 2) }}</p>
                <p><strong>Total Donation:</strong> {{ number_format($summary['donation'] ?? 0, 2) }}</p>
            </div>
        @endforeach
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('signature-pad');
        const ctx = canvas.getContext('2d');
        let drawing = false;

        function startPosition(e) {
            drawing = true;
            draw(e);
        }

        function finishedPosition() {
            drawing = false;
            ctx.beginPath();
        }

        function draw(e) {
            if (!drawing) return;
            e.preventDefault();
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';

            ctx.lineTo(x, y);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(x, y);
        }

        // Mouse events
        canvas.addEventListener('mousedown', startPosition);
        canvas.addEventListener('mouseup', finishedPosition);
        canvas.addEventListener('mousemove', draw);

        // Touch events
        canvas.addEventListener('touchstart', startPosition);
        canvas.addEventListener('touchend', finishedPosition);
        canvas.addEventListener('touchmove', draw);

        document.getElementById('clear-signature').addEventListener('click', function () {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });

        function isCanvasBlank(canvas) {
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;
            return canvas.toDataURL() === blank.toDataURL();
        }

        document.getElementById('submit-collection').addEventListener('click', async function () {
            const collectionType = document.getElementById('collection-type').value;
            const amount = document.getElementById('amount-collected').value;
            const usherName = document.getElementById('usher-name').value;

            if (!amount || amount <= 0) {
                alert('Please enter a valid amount.');
                return;
            }

            if (isCanvasBlank(canvas)) {
                alert('Please provide a signature.');
                return;
            }

            const signatureDataUrl = canvas.toDataURL();

            try {
                const response = await fetch('/api/usher-collections', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        usherName: usherName,
                        collectionType: collectionType,
                        amount: parseFloat(amount),
                        signatureDataUrl: signatureDataUrl
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    document.getElementById('amount-collected').value = '';
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    const messageDiv = document.getElementById('message');
                    messageDiv.textContent = data.message || 'Collection saved successfully!';
                    setTimeout(() => {
                        messageDiv.textContent = '';
                    }, 3000);
                } else {
                    alert(data.error || 'Failed to save collection.');
                }
            } catch (error) {
                alert('Error submitting collection: ' + error.message);
            }
        });
    });
</script>
@endsection
