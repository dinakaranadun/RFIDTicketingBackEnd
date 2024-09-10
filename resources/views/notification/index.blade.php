@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Notification Content</label>
                                    <div class="form-group">
                                        <input type="text" name="message" class="form-control"
                                            value="{{ request()->get('message', '') }}">
                                    </div>
                                    @error('title')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-info btn-round">Search</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('notification.create') }}" class="btn btn-primary btn-round">Send new
                                        Notification</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Search result
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>Message</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            
                                            <td>
                                                {{ Str::limit($notification->message, 50) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('notification.edit', $notification->id) }}"
                                                    class="btn btn-warning btn-round">Edit</a>
                                                <form action="{{ route('notification.destroy', $notification->id) }}" method="POST"
                                                    style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-round"
                                                        onclick="return confirm('Are you sure you want to delete this notification?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
