@extends('layouts.app')
@section('title', 'Add New Notification')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('notification.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Notification Message</label>
                                    <div class="form-group">
                                        <textarea name="message" class="form-control">{{ old('message', '') }}</textarea>
                                    </div>
                                    @error('message')
                                    <strong class="invalid-feedback d-block">{{ $message }}</strong>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-round">Send Notification</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
