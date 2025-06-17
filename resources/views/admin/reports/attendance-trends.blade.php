@extends('layouts.app')

@section('content')
    <h1>Attendance Trends</h1>
    <p>Showing attendance trends from {{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</p>

    <div style="display: flex; gap: 2rem;">
        <div style="flex: 1;">
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Attendance Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendanceData as $data)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($data->date)->format('Y-m-d') }}</td>
                            <td>{{ $data->count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="flex: 1;">
            <canvas id="attendanceChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('attendanceChart').getContext('2d');
        const attendanceData = @json($attendanceData);

        const labels = attendanceData.map(item => new Date(item.date).toISOString().split('T')[0]);
        const dataCounts = attendanceData.map(item => item.count);

        const attendanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Attendance Count',
                    data: dataCounts,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    }
                }
            }
        });
    </script>
@endsection
