@extends('layouts.app')
@section('title', 'Add new Station')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('station.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Station Name</label>
                                    <div class="form-group">
                                        <input type="text" name="station_name" class="form-control"
                                            value="{{ old('station_name', '') }}">
                                    </div>
                                    @error('station_name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Distance from Central Station</label>
                                    <div class="input-group">
                                        <input type="text" name="distance_from_central_station" class="form-control"
                                            value="{{ old('distance_from_central_station', '') }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text">KM</span>
                                        </div>
                                    </div>
                                    @error('distance_from_central_station')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-round">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
