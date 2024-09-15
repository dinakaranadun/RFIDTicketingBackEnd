@extends('layouts.app')
@section('title', 'Passenger Refund Requests')
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
                                    <th>Passenger First Name</th>
                                    <th>Passenger Last Name</th>
                                    <th>NIC</th>
                                    <th>Ticket Cost</th>
                                    <th>Passenger Status</th>
                                    <th>Start Station</th>
                                    <th>End Station</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        @if ($ticket->status == 'refund requested')
                                            <tr> 
                                                <td>
                                                    {{ $ticket->passenger->fName }}
                                                </td>
                                                <td>
                                                    {{ $ticket->passenger->lName }}
                                                </td>
                                                <td>
                                                    {{ $ticket->passenger->NIC }}
                                                </td>
                                                <td>
                                                    {{ $ticket->cost }}
                                                </td>
                                                <td>
                                                    {{ $ticket->passenger->status }}
                                                </td>
                                                <td>
                                                    {{ $ticket->startStation->station_name }}
                                                </td>
                                                <td>
                                                    {{ $ticket->endStation->station_name }}
                                                </td>
                                                <td>
                                                    <form action="{{ route('refund.update', ['ticket' => $ticket->id, 'passenger' => $ticket->passenger->id]) }}" method="POST"
                                                        style="display: inline-block">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit" class="btn btn-danger btn-round"
                                                            onclick="return confirm('Are you sure you want to refund')">Refund Ticket Cost</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Refunded Tickets
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>Passenger First Name</th>
                                    <th>Passenger Last Name</th>
                                    <th>NIC</th>
                                    <th>Ticket Cost</th>
                                    <th>Passenger Status</th>
                                    <th>Start Station</th>
                                    <th>End Station</th>
                                    <th>Refund Status</th>
                                </thead>
                                <tbody>
                                    @foreach ($tickets as $ticket)
                                        @if ($ticket->status == 'refunded')
                                            <tr> 
                                                <td>
                                                    {{ $ticket->passenger->fName }}
                                                </td>
                                                <td>
                                                    {{ $ticket->passenger->lName }}
                                                </td>
                                                <td>
                                                    {{ $ticket->passenger->NIC }}
                                                </td>
                                                <td>
                                                    {{ $ticket->cost }}
                                                </td>
                                                <td>
                                                    {{ $ticket->passenger->status }}
                                                </td>
                                                <td>
                                                    {{ $ticket->startStation->station_name }}
                                                </td>
                                                <td>
                                                    {{ $ticket->endStation->station_name }}
                                                </td>
                                                <td>
                                                    Refunded
                                                </td>
                                            </tr>
                                        @endif  
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
