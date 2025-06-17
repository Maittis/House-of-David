@extends('layouts.superadmin')

@section('content')
<div class="container">
    <h1>Superadmin Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}! This is the superadmin dashboard.</p>

    <!-- Add superadmin-specific content here, such as money reports -->

    <!-- Superadmin Dashboard Section -->
    <section id="section-admin-dashboard">
        <h2>Usher Collection Reports</h2>
        <div>
            <label for="filter-usher">Filter by Usher Name:</label>
            <input type="text" id="filter-usher" placeholder="Type usher name to filter" />
        </div>
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Usher Name</th>
                    <th>Collection Type</th>
                    <th>Amount</th>
                    <th>Signature</th>
                </tr>
            </thead>
            <tbody id="admin-report-body">
                @foreach ($usherCollections as $collection)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($collection['timestamp'] ?? $collection['dateTime'] ?? now())->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $collection['usherName'] ?? $collection['usher_name'] }}</td>
                    <td>{{ $collection['collectionType'] ?? $collection['collection_type'] }}</td>
                    <td>{{ number_format($collection['amount'], 2) }}</td>
                    <td>
                        @if (!empty($collection['signatureDataUrl'] ?? $collection['signature']))
                        <img src="{{ $collection['signatureDataUrl'] ?? $collection['signature'] }}" alt="Signature" style="max-width: 150px; max-height: 50px;" />
                        @else
                        N/A
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="admin-report-message"></div>
    </section>

    <!-- Tithe and Donation Summary Section -->
    <section id="section-tithe-donation-summary" style="margin-top: 3rem;">
        <h2>Tithe and Donation Summary</h2>
        <div>
            <p><strong>Total Tithe:</strong> {{ number_format($totalTithe ?? 0, 2) }}</p>
            <p><strong>Total Offering:</strong> {{ number_format($totalOffering ?? 0, 2) }}</p>
            <p><strong>Total Donations:</strong> {{ number_format($totalDonations ?? 0, 2) }}</p>
        </div>
        <div style="margin-top: 1rem;">
            <button onclick="location.href='{{ route('donations.weekly-report') }}'" class="btn btn-primary">Generate Weekly Report</button>
            <button onclick="location.href='{{ route('donations.monthly-report') }}'" class="btn btn-primary">Generate Monthly Report</button>
            <button onclick="location.href='{{ route('superadmin.usher-collections.export') }}'" class="btn btn-success ml-2">Download Usher Collections Excel</button>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterInput = document.getElementById('filter-usher');
        const tableBody = document.getElementById('admin-report-body');

        filterInput.addEventListener('input', function () {
            const filterValue = this.value.toLowerCase();
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const usherNameCell = rows[i].getElementsByTagName('td')[1];
                if (usherNameCell) {
                    const usherName = usherNameCell.textContent || usherNameCell.innerText;
                    if (usherName.toLowerCase().indexOf(filterValue) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        });
    });
</script>
@endsection
