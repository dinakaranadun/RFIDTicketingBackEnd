@extends('layouts.auth')
@section('title', 'Login')
@section('content')
    <div class="content">
        <div class="container">
            <div class="col-lg-4 col-md-6 ml-auto mr-auto">
                <form class="form" method="POST" action="{{ route('authenticate') }}">
                    @csrf
                    <div class="card card-login">
                        <div class="card-header ">
                            <div class="card-header ">
                                <h3 class="header text-center">Login</h3>
                            </div>
                        </div>
                        <div class="card-body ">

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    placeholder="Email" type="email" name="email"
                                    value="{{ old('email') }}" required autofocus>

                                @error('email')
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="nc-icon nc-single-02"></i>
                                    </span>
                                </div>
                                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password" placeholder="Password" type="password" required>

                                @error('password')
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" name="remember" type="checkbox" value=""
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <span class="form-check-sign"></span>
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning btn-round mb-3">Sign In</button>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- <a href="{{ route('password.request') }}" class="btn btn-link">
                    Forgot Password
                </a>
                <a href="{{ route('register') }}" class="btn btn-link float-right">
                    Create Accouunt
                </a> --}}
            </div>
        </div>
    </div>
@endsection
