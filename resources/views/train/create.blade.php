@extends('layouts.app')
@section('title', 'Add new Train')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('train.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', '') }}">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Start Station</label>
                                    <div class="form-group">
                                        <select name="start_station" class="form-control">
                                            <option value="">Select Station</option>
                                            @foreach ($stations as $station)
                                                <option value="{{ $station->id }}"
                                                    {{ old('start_station') == $station->id ? 'selected' : '' }}>
                                                    {{ $station->station_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('start_station')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">End Station</label>
                                    <div class="form-group">
                                        <select name="end_station" class="form-control">
                                            <option value="">Select Station</option>
                                            @foreach ($stations as $station)
                                                <option value="{{ $station->id }}"
                                                    {{ old('end_station') == $station->id ? 'selected' : '' }}>
                                                    {{ $station->station_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('end_station')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Train Type</label>
                                    <div class="form-group">
                                        <select name="train_type" class="form-control">
                                            <option value="">Select Train Type</option>
                                            @foreach (config('common.train_types') as $train_type_id => $train_type)
                                                <option value="{{ $train_type_id }}"
                                                    {{ old('train_type') == $train_type_id ? 'selected' : '' }}>
                                                    {{ $train_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('train_type')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Working Days</label>
                                    <div class="form-group">
                                        <select name="working_days" class="form-control">
                                            <option value="" disabled selected>Select Working Days</option>
                                            <option value="all" >All Days</option>
                                            <option value="weekend" >WeekEnd</option>
                                        </select>
                                    </div>
                                    @error('working_days')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Special Notes</label>
                                    <div class="form-group">
                                        <input type="text" name="special_note" class="form-control"
                                            value="{{ old('special_notes', '') }}">
                                    </div>
                                    @error('special_note')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6>Class Availability</h6>
                                    <hr class="mt-1">
                                    <div class="row">
                                        @foreach (config('common.train_classes') as $clss_id => $train_class)
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <input id="train_class_{{ $clss_id }}" type="checkbox"
                                                        name="available_classes[]" value="{{ $clss_id }}"
                                                        class="form-control d-inline w-auto" @checked(in_array($clss_id, old('available_classes', [])))>
                                                    <label for="train_class_{{ $clss_id }}"
                                                        class="form-check-label">{{ $train_class }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                        @error('available_classes')
                                            <div class="col-12">
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
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
                </div>
            </div>
        </div>
    </div>
@endsection
