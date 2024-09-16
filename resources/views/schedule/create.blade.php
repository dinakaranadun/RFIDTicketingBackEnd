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
                                    @error('train')
                                    <strong class="invalid-feedback d-block">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <select name="route" class="form-control">
                                        <option value="">Select Route</option>
                                        @foreach ($routes as $route)
                                            <option value="{{ $route->id }}"
                                                {{ old('route') == $route->id ? 'selected' : '' }}>
                                                {{ $route->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('route')
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
                                            <button type="button" id="add-station" class="btn btn-primary btn-round float-right">Add Station</button>
                                        </div>
                                        @forelse(old('stations', []) as $key => $stationL)
                                            <div class="col-md-4 station-group mb-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-info move-station-up" @disabled($key == 0)><i class="nc-icon nc-minimal-up"></i></button>
                                                        <button type="button" class="btn btn-info move-station-down" @disabled($key == old('stations',[])->count() - 1)><i class="nc-icon nc-minimal-down"></i></button>
                                                        <span class="input-group-text station_order pb-0 pr-3">{{ $key + 1 }}</span>
                                                    </div>
                                                    <select name="stations[]" class="form-control station" data-ord="{{ $key + 1 }}">
                                                        <option value="">Select Station</option>
                                                        @foreach ($stations as $station)
                                                            <option value="{{ $station->id }}"
                                                                {{ $stationL == $station->id ? 'selected' : '' }}>
                                                                {{ $station->station_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger remove-station m-0"><i class="nc-icon nc-simple-remove"></i></button>
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
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-info move-station-up" disabled><i class="nc-icon nc-minimal-up"></i></button>
                                                        <button type="button" class="btn btn-info move-station-down" disabled><i class="nc-icon nc-minimal-down"></i></button>
                                                        <span class="input-group-text station_order pb-0 pr-3"></span>
                                                    </div>
                                                    <select name="stations[]" class="form-control station">
                                                        <option value="">Select Station</option>
                                                        @foreach ($stations as $station)
                                                            <option value="{{ $station->id }}">{{ $station->station_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger m-0 remove-station"><i class="nc-icon nc-simple-remove"></i></button>
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
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-info move-station-up">
                                        <i class="nc-icon nc-minimal-up"></i></button>
                                    <button type="button" class="btn btn-info move-station-down">
                                        <i class="nc-icon nc-minimal-down"></i></button>
                                    <span class="input-group-text station_order pb-0 pr-3"></span>
                                </div>
                                <select name="stations[]" class="form-control station">
                                    <option value="">Select Station</option>
                                    @foreach ($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->station_name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-danger m-0 remove-station"><i class="nc-icon nc-simple-remove"></i></button>
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
                updateStationOrder();
            });

            $(document).on('click', '.move-station-up', function () {
                moveStation($(this).closest('.station-group').find('.station'), -1);
            });

            $(document).on('click', '.move-station-down', function () {
                moveStation($(this).closest('.station-group').find('.station'), 1);
            });

            function moveStation(fromStation, movement) {
                let fromOrd = fromStation.attr('data-ord');
                let toOrd = parseInt(fromOrd) + movement;
                $('#stations .station').each(function (index) {
                    if (toOrd == $(this).attr('data-ord')) {
                        let tmp = $(this).val();
                        $(this).val(fromStation.val());
                        fromStation.val(tmp);
                    }
                });
                updateStationOrder();
            }

            $('#add-station').click(function () {
                $('#stations').append($('#station_base').html());
                updateStationOrder();
            });

            function updateStationOrder() {
                $('#stations .station_order').each(function (index) {
                    $(this).text(index + 1);
                    $(this).closest('.station-group').find('.station').attr('data-ord', index + 1);
                });
                $('#stations .station').each(function (index) {
                    let moveUpButton = $(this).closest('.input-group').find('.move-station-up');
                    let moveDownButton = $(this).closest('.input-group').find('.move-station-down');
                    moveUpButton.prop('disabled', index === 0);
                    moveDownButton.prop('disabled', index === $('#stations .station').length - 1);
                });
            }
        });
    </script>
@endpush
