@extends('layouts.app')
@section('title', 'Add new Route')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('route.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Route Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control"
                                               value="{{ old('name', '') }}">
                                    </div>
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
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button"
                                                                class="btn btn-info m-0 px-2 move-station-up" disabled>
                                                            <i class="nc-icon nc-minimal-up"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-info m-0 px-2 move-station-down">
                                                            <i class="nc-icon nc-minimal-down"></i>
                                                        </button>
                                                        <span
                                                            class="input-group-text station_order pb-0 pr-3 d-md-block d-none">{{$key + 1}}</span>
                                                    </div>

                                                    <select name="stations[]" class="form-control station" data-ord="{{$key + 1}}">
                                                        <option value="">Select Station</option>
                                                        @foreach ($stations as $station)
                                                            <option value="{{ $station->id }}"
                                                                {{ $stationL == $station->id ? 'selected' : '' }}>
                                                                {{ $station->station_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger remove-station m-0">
                                                            <i class="nc-icon nc-simple-remove"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('stations.' . $key)
                                                <strong class="invalid-feedback d-block">{{ $message }}</strong>
                                                @enderror
                                            </div>
                                        @empty
                                            <div class="col-md-4">
                                                {{--<label class="form-label">Station</label>--}}
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <button type="button"
                                                                class="btn btn-info m-0 px-2 move-station-up" disabled>
                                                            <i class="nc-icon nc-minimal-up"></i>
                                                        </button>
                                                        <button type="button"
                                                                class="btn btn-info m-0 px-2 move-station-down" disabled>
                                                            <i class="nc-icon nc-minimal-down"></i>
                                                        </button>
                                                        <span
                                                            class="input-group-text station_order pb-0 pr-3 d-md-block d-none">1</span>
                                                    </div>

                                                    <select name="stations[]" class="form-control station" data-ord="">
                                                        <option value="">Select Station</option>
                                                        @foreach ($stations as $station)
                                                            <option
                                                                value="{{ $station->id }}">{{ $station->station_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-danger remove-station m-0">
                                                            <i class="nc-icon nc-simple-remove"></i>
                                                        </button>
                                                    </div>
                                                </div>
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
                        <div class="col-md-4">
                            {{--<label class="form-label">Station</label>--}}
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button"
                                            class="btn btn-info m-0 px-2 move-station-up">
                                        <i class="nc-icon nc-minimal-up"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-info m-0 px-2 move-station-down">
                                        <i class="nc-icon nc-minimal-down"></i>
                                    </button>
                                    <span
                                        class="input-group-text station_order pb-0 pr-3 d-md-block d-none"></span>
                                </div>
                                <select name="stations[]" class="form-control station">
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
                $(this).closest('.col-md-4').remove();
                updateStationOrder();
            });
            $(document).on('click', '.move-station-up', function () {
                moveStation($(this).closest('.col-md-4').find('.station'), -1);
            });
            $(document).on('click', '.move-station-down', function () {
                moveStation($(this).closest('.col-md-4').find('.station'), 1);
            });

            function moveStation(fromStation, movement) {
                let fromOrd = fromStation.attr('data-ord');
                let toOrd = parseInt(fromOrd) + movement;
                $('#stations .station').each(function (index) {
                    if (toOrd == $(this).attr('data-ord')) {
                        tmp = $(this).val();
                        $(this).val(fromStation.val());
                        fromStation.val(tmp);
                    }
                })
            }

            $('#add-station').click(function () {
                $('#stations').append($('#station_base').html());
                updateStationOrder();
            });

            function updateStationOrder() {
                $('#stations .station_order').each(function (index) {
                    $(this).text(index + 1);
                    $(this).closest('.col-md-4').find('.station').attr('data-ord', index + 1);
                });
                $('#stations .station').each(function (index) {
                    if (index == 0) {
                        $(this).closest('.input-group').find('.move-station-up').attr('disabled', true);
                    } else {
                        $(this).closest('.input-group').find('.move-station-up').attr('disabled', false);
                    }
                    if (index == $('#stations .station').length - 1) {
                        $(this).closest('.input-group').find('.move-station-down').attr('disabled', true);
                    } else {
                        $(this).closest('.input-group').find('.move-station-down').attr('disabled', false);
                    }
                });
            }
        });
    </script>
@endpush
