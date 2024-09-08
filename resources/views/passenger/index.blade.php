@extends('layouts.app')
@section('title', 'Passenger')
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
                                <div class="col-md-4">
                                    <label class="form-label">Email</label>
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control"
                                            value="{{ request()->get('email', '') }}">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $error }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">NIC</label>
                                    <div class="form-group">
                                        <input type="text" name="NIC" class="form-control"
                                            value="{{ request()->get('NIC', '') }}">
                                    </div>
                                    @error('NIC')
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
                                    <a href="{{ route('passenger.create') }}" class="btn btn-primary btn-round">Add New
                                        Passenger</a>
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
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>NIC</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Account Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($passengers as $passenger)
                                        <tr>
                                            <td>
                                                {{ $passenger->fName }}
                                            </td>
                                            <td>
                                                {{ $passenger->lName }}
                                            </td>
                                            <td>
                                                {{ $passenger->NIC }}
                                            </td>
                                            <td>
                                                {{ $passenger->email }}
                                            </td>
                                            <td>
                                                {{ $passenger->contact_number }}
                                            </td>
                                            <td>
                                                {{ $passenger->status }}
                                            </td>
                                            <td>
                                                <a href="{{ route('passenger.edit', $passenger->id) }}"
                                                    class="btn btn-warning btn-round">Edit</a>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $passengers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
