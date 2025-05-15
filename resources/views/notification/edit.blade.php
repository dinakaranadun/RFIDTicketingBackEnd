@extends('layouts.app')
@section('title', 'Edit Notification')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('notification.update', $notification->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Message</label>
                                    <div class="form-group">
                                        <textarea name="message" class="form-control" rows="4" required>{{ old('message', $notification->message) }}</textarea>
                                    </div>
                                    @error('message')
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
                                    <button type="submit" class="btn btn-primary btn-round">Update Notification</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
