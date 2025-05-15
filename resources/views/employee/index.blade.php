@extends('layouts.app')
@section('title', 'Employee')
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
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-info btn-round">Search</button>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('employee.create') }}" class="btn btn-primary btn-round">Create new
                                        Employee</a>
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
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $employee)
                                        <tr>
                                            <td>
                                                {{ $employee->fName }}
                                            </td>
                                            <td>
                                                {{ $employee->lName }}
                                            </td>
                                            <td>
                                                {{ $employee->NIC }}
                                            </td>
                                            <td>
                                                {{ $employee->email }}
                                            </td>
                                            <td>
                                                {{ $employee->contact_number }}
                                            </td>
                                            <td>
                                                <a href="{{ route('employee.edit', $employee->id) }}"
                                                    class="btn btn-warning btn-round">Edit</a>
                                                <form action="{{ route('employee.destroy', $employee->id) }}"
                                                    method="POST" style="display: inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-round"
                                                        onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                                                </form>
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $employees->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
