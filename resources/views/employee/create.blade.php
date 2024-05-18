@extends('layouts.app')
@section('title', 'Add new Employee')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('employee.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">First Name</label>
                                    <div class="form-group">
                                        <input type="text" name="fname" class="form-control"
                                            value="{{ old('fname', '') }}">
                                    </div>
                                    @error('fname')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Last Name</label>
                                    <div class="form-group">
                                        <input type="text" name="lname" class="form-control"
                                            value="{{ old('lname', '') }}">
                                    </div>
                                    @error('lname')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">NIC</label>
                                    <div class="form-group">
                                        <input type="text" name="nic" class="form-control"
                                            value="{{ old('nic', '') }}">
                                    </div>
                                    @error('nic')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', '') }}">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Password</label>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control"
                                            value="">
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Confirm Password</label>
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Contact Number</label>
                                    <div class="form-group">
                                        <input type="text" name="contact_number" class="form-control"
                                            value="{{ old('contact_number', '') }}">
                                    </div>
                                    @error('contact_number')
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
