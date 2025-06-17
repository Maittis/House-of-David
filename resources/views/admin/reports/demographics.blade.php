@extends('layouts.app')

@section('content')
    <h1>Demographic Reports</h1>

    <div style="display: flex; gap: 2rem;">
        <div style="flex: 1;">
            <h3>Age Groups</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Age Group</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ageGroups as $group => $count)
                        <tr>
                            <td>{{ $group }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3>Gender Ratios</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Gender</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genderCounts as $gender => $count)
                        <tr>
                            <td>{{ $gender }}</td>
                            <td>{{ $count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="flex: 1;">
            <canvas id="demographicsChart" width="400" height="400"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('demographicsChart').getContext('2d');

        const ageGroups = @json($ageGroups);
        const genderCounts = @json($genderCounts);

        const ageLabels = Object.keys(ageGroups);
        const ageData = Object.values(ageGroups);

        const genderLabels = Object.keys(genderCounts);
        const genderData = Object.values(genderCounts);

        const demographicsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ageLabels.concat(genderLabels),
                datasets: [{
                    label: 'Count',
                    data: ageData.concat(genderData),
                    backgroundColor: [
                        ...ageLabels.map(() => 'rgba(54, 162, 235, 0.7)'),
                        'rgba(78, 235, 54, 0.7)', // Male color
                        'rgba(255, 99, 132, 0.7)'  // Female color
                    ],
                    borderColor: [
                        ...ageLabels.map(() => 'rgba(54, 162, 235, 1)'),
                        'rgb(66, 233, 166)', // Male border color
                        'rgba(255, 99, 132, 1)'  // Female border color
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                }
            }
        });
    </script>
@endsection
