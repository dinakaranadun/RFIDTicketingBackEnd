@extends('layouts.app')
@section('title', 'Add new Schedule')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="train" class="form-control">
                                        <option value="">Select Train</option>
                                        @foreach ($trains as $train)
                                            <option value="{{ $train->id }}"
                                                {{ old('train') == $train->id ? 'selected' : '' }}>
                                                {{ $train->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                    <strong class="invalid-feedback d-block">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <div id="stations" class="row">
                                        <div class="col-md-6">
                                            <h6>Stations</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" id="add-station" class="btn btn-primary btn-round float-right">Add
                                                Station</button>
                                        </div>
                                        @forelse(old('stations', []) as $key => $stationL)
                                            <div class="col-md-4 station-group">
                                                <div class="input-group">
                                                    <select name="stations[]" class="form-control">
                                                        <option value="">Select Station</option>
                                                        @foreach ($stations as $station)
                                                            <option value="{{ $station->id }}"
                                                                {{ $stationL == $station->id ? 'selected' : '' }}>
                                                                {{ $station->station_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger remove-station m-0"><i
                                                                class="nc-icon nc-simple-remove"></i></button>
                                                    </div>
                                                </div>
                                                <label class="form-label">Arrival Time</label>
                                                <input type="time" name="arrival_times[]" class="form-control mt-2" placeholder="Arrival Time">
                                                <label class="form-label">Departure Time</label>
                                                <input type="time" name="departure_times[]" class="form-control mt-2" placeholder="Departure Time">
                                                @error('stations.' . $key)
                                                <strong class="invalid-feedback d-block">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        @empty
                                            <div class="col-md-4 station-group mb-4">
                                                <div class="input-group">
                                                    <select name="stations[]" class="form-control">
                                                        <option value="">Select Station</option>
                                                        @foreach ($stations as $station)
                                                            <option
                                                                value="{{ $station->id }}">{{ $station->station_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger m-0 remove-station"><i
                                                                class="nc-icon nc-simple-remove"></i></button>
                                                    </div>
                                                </div>
                                                <label class="form-label">Arrival Time</label>
                                                <input type="time" name="arrival_times[]" class="form-control mt-2" placeholder="Arrival Time">
                                                <label class="form-label">Departure Time</label>
                                                <input type="time" name="departure_times[]" class="form-control mt-2" placeholder="Departure Time">
                                            </div>
                                        @endforelse
                                    </div>
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
                    <div id="station_base" style="display: none;">
                        <div class="col-md-4 station-group mb-4">
                            <div class="input-group">
                                <select name="stations[]" class="form-control">
                                    <option value="">Select Station</option>
                                    @foreach ($stations as $station)
                                        <option
                                            value="{{ $station->id }}">{{ $station->station_name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger m-0 remove-station"><i
                                            class="nc-icon nc-simple-remove"></i></button>
                                </div>
                            </div>
                            <label class="form-label">Arrival Time</label>
                            <input type="time" name="arrival_times[]" class="form-control mt-2" placeholder="Arrival Time">
                            <label class="form-label">Departure Time</label>
                            <input type="time" name="departure_times[]" class="form-control mt-2" placeholder="Departure Time">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.remove-station', function () {
                $(this).closest('.station-group').remove();
            });

            $('#add-station').click(function () {
                $('#stations').append($('#station_base').html());
            });
        });
    </script>
@endpush
