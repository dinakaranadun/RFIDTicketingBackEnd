@extends('layouts.app')
@section('title', 'Reports')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Select Report Type</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5>Passenger Flow Report</h5>
                                        <p>Generate a report on passenger flow.</p>
                                        <a href="{{ route('passengerflow.index')}}" class="btn btn-info btn-round">Generate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5>Revenue Report</h5>
                                        <p>Generate a revenue report.</p>
                                        <a href="{{ route('revenue.index') }}" class="btn btn-info btn-round">Generate</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <p class="text-center">Select the type of report you want to generate.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
