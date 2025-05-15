@extends('layouts.app')
@section('title', 'Passenger Flow Report')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="GET" action="{{ route('report.passengerFlowGenerate') }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Select Route</label>
                                    <div class="form-group">
                                        <select name="route_id" id="routeSelect" class="form-control" required>
                                            <option value="" disabled selected>Select a route</option>
                                            @foreach ($routes as $route)
                                                <option value="{{ $route->id }}" {{ isset($selectedRoute) && $selectedRoute->id == $route->id ? 'selected' : '' }}>
                                                    {{ $route->name }}
                                                </option>
                                            @endforeach
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

            <!-- Passenger Flow Data  -->
            @if(isset($passengerFlow))
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Passenger Flow Data
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Station</th>
                                        <th>Passenger Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selectedRoute->stations as $station)
                                        <tr>
                                            <td>{{ $station->station_name }}</td>
                                            <td>{{ $passengerFlow[$station->id] ?? 0 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Passenger Flow Chart -->
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        Passenger Flow Chart
                    </div>
                    <div class="card-body">
                        <canvas id="routeSequenceChart"></canvas>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
@if(isset($passengerFlow))
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
    new Chart(document.getElementById('routeSequenceChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($selectedRoute->stations->pluck('station_name')),
            datasets: [{
                label: 'Passenger Count',
                data: @json($selectedRoute->stations->pluck('id')->map(function($id) use ($passengerFlow) {
                    return $passengerFlow[$id] ?? 0;
                })),
                borderColor: "#4fddff",
                backgroundColor: "rgba(79, 221, 255, 0.2)", 
                borderWidth: 1
            }]
        },
        // options: {
        //     scales: {
        //         y: {
        //             beginAtZero: true
        //         }
        //     }
        // }
    });
</script>
@endif
@endpush
