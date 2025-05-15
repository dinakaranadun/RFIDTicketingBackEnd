@extends('layouts.app')
@section('title', 'Revenue Report')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="GET" action="{{ route('report.revenueGenerate') }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Report Type</label>
                                    <div class="form-group">
                                        <select name="report_type" id="reportSelect" class="form-control" required>
                                            <option value="" disabled >Select Report Type</option>
                                            <option value="monthly" {{ old('route_id', $report_type ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="date" {{ old('route_id', $report_type ?? '') == 'date' ? 'selected' : '' }}>By Date</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Start Date</label>
                                    <div class="form-group">
                                        <input type="date" name="start_date" class="form-control" 
                                            value="{{ old('start_date', $start_date ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">End Date</label>
                                    <div class="form-group">
                                        <input type="date" name="end_date" class="form-control" 
                                            value="{{ old('end_date', $end_date ?? '') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info btn-round">Generate Report</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daily Revenue Table -->
            @if(isset($earn_per_day) && $report_type === 'date')
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Daily Revenue Data
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Date</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($earn_per_day as $date => $earn)
                                        <tr>
                                            <td>{{ $date }}</td>
                                            <td>Rs.{{ number_format($earn, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Monthly Revenue Table -->
            @if(isset($earn_per_month) && $report_type === 'monthly')
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Monthly Revenue Data
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Month</th>
                                        <th>Revenue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($earn_per_month as $month => $earn)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</td>
                                            <td>Rs.{{ number_format($earn, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Revenue Chart -->
            @if(isset($earn_per_month) && $report_type === 'monthly')
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            Monthly Revenue Chart
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            @endif

            @if(isset($earn_per_day) && $report_type === 'date')
                <div class="col-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            Daily Revenue Chart
                        </div>
                        <div class="card-body">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
@if(isset($earn_per_month) && $report_type === 'monthly')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json(array_map(function($month) {
                return \Carbon\Carbon::parse($month)->format('F Y'); 
            }, array_keys($earn_per_month))),
            datasets: [{
                label: 'Monthly Revenue in Sri Lankan Rupees',
                data: @json(array_values($earn_per_month)),
                borderColor: "#4fddff",
                backgroundColor: "rgba(79, 221, 255, 0.2)",
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                }
            }
        }
    });
</script>
@endif

@if(isset($earn_per_day) && $report_type === 'date')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    new Chart(document.getElementById('revenueChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json(array_keys($earn_per_day)),
            datasets: [{
                label: 'Daily Revenue in Sri Lankan Rupees',
                data: @json(array_values($earn_per_day)),
                borderColor: "#4fddff",
                backgroundColor: "rgba(79, 221, 255, 0.2)",
                borderWidth: 1,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Revenue'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });
</script>
@endif
@endpush
