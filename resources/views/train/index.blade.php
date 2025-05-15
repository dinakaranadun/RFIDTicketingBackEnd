@extends('layouts.app')
@section('title', 'Train')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="GET">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Name</label>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control"
                                            value="{{ request()->get('name', '') }}">
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $error }}</strong>
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
                                    <a href="{{ route('train.create') }}" class="btn btn-primary btn-round">Create new
                                        Train</a>
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
                                    <th>Name</th>
                                    <th>Start Station</th>
                                    <th>End Station</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($trains as $train)
                                        <tr>
                                            <td>
                                                {{ $train->name }}
                                            </td>
                                            <td>
                                                {{ $train->startStation->station_name }}
                                            </td>
                                            <td>
                                                {{ $train->endStation->station_name }}
                                            </td>
                                            <td>
                                                {{ config('common.train_types')[$train->train_type] ?? '' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('train.edit', $train->id) }}"
                                                    class="btn btn-warning btn-round">Edit</a>
                                                <form action="{{ route('train.destroy', $train->id) }}" method="POST"
                                                    style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-round"
                                                        onclick="return confirm('Are you sure you want to delete this station?')">Delete</button>
                                                </form>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $trains->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
