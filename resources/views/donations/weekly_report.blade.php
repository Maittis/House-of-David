@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-chart-bar"></i> 
            @yield('report_title', 'Weekly Donation Report')
        </h1>
        <div>
            <a href="@yield('export_route')" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export
            </a>
            <a href="{{ route('donations.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Donations
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Collected
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                ₦{{ number_format($total, 2) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Period
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @yield('report_period')
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables -->
    <div class="row">
        <!-- By Type -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Donations by Type
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="bg-light">
                                <tr>
                                    <th>Type</th>
                                    <th>Count</th>
                                    <th>Amount</th>
                                    <th>% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($report as $item)
                                <tr>
                                    <td>{{ ucfirst($item->type) }}</td>
                                    <td>{{ $item->count }}</td>
                                    <td>₦{{ number_format($item->total_amount, 2) }}</td>
                                    <td>{{ round(($item->total_amount / $total) * 100, 1) }}%</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- By Payment Method -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Payment Methods
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="paymentMethodsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Payment Methods Chart
    new Chart(document.getElementById('paymentMethodsChart'), {
        type: 'doughnut',
        data: {
            labels: @json($methods->pluck('payment_method')->map(fn($m) => ucfirst($m))),
            datasets: [{
                data: @json($methods->pluck('total')),
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'
                ],
                hoverBorderColor: "#fff"
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
@endpush
@endsection