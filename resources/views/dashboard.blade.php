@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="" class="card-link">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-money-coins text-warning"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Bookings</p>
                                        <p class="card-title">Rs. {{ $total_revenue }}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-refresh"></i> Detailed Reports
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('train.index') }}" class="card-link">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-bus-front-12 text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Trains</p>
                                        <p class="card-title">{{$total_trains}}<p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-calendar-o"></i> Manage Trains
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('station.index') }}" class="card-link">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-map-big text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Stations</p>
                                        <p class="card-title">{{$total_stations}}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-clock-o"></i> Manage Stations
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <a href="{{ route('route.index') }}" class="card-link">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-chat-33 text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Forum Threads</p>
                                        <p class="card-title">{{ $total_forums }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="fa fa-refresh"></i> Manage Routes
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card card-stats p-3">
                    <div class="numbers">
                        <p class="card-category">Earnings per Day</p>
                    </div>
                    <canvas id="earnPerDay"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <script>
        new Chart(document.getElementById('earnPerDay').getContext("2d"), {
            type: 'line',
            data: {
                labels: @json(array_keys($earn_per_day)),
                datasets: [{
                    label: 'Earning',
                    data: @json(array_values($earn_per_day)),
                    // borderWidth: 1
                    borderColor: "#f17e5d",
                    backgroundColor: "#ffc6b5",
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
@endpush
