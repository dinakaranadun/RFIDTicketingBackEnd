@extends('layouts.app')
@section('title', 'Edit Passenger')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form action="{{ route('passenger.update', $passenger->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">First Name</label>
                                    <div class="form-group">
                                        <input type="text" name="fname" class="form-control"
                                            value="{{ old('fname', $passenger->fName) }}">
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
                                            value="{{ old('lname', $passenger->lName) }}">
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
                                            value="{{ old('nic', $passenger->NIC) }}">
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
                                            value="{{ old('email', $passenger->email) }}">
                                    </div>
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Password <small>(Type a password if you want to change the password of this user)</small></label>
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
                                            value="{{ old('contact_number', $passenger->contact_number) }}">
                                    </div>
                                    @error('contact_number')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="is_active">Status</label>
                                    <select id="status"  name="status" class="form-control">
                                        <option value="active" {{$passenger->status == "active" ? 'selected' : ''}}>Active</option>
                                        <option value="inactive" {{$passenger->status == "inactive" ? 'selected' : ''}}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">RFID</label>
                                    <div class="form-group">
                                        <input type="text" name="rfid" id="rfid" class="form-control"
                                            value="{{ old('rfid', $passenger->rfid) }}"
                                            disabled>
                                    </div>
                                    @error('rfid')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <button type="button" class="btn btn-dark btn-round" id="rfid-btn">Add RFID</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary btn-round">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let interval;

    $(document).ready(function() {
        $('#rfid-btn').on('click', function() {
            // Clear the input and focus the RFID field
            $('#rfid').val('').focus();

            // Start polling for RFID
            interval = setInterval(checkForRFID, 2000); // Poll every 2 seconds
        });
        
        $('form').on('submit', function() {
        $('#rfid').prop('disabled', false);
    });

        function checkForRFID() {
            // Fetch the RFID directly from the PHP file
            $.ajax({
                url: '/readRFID.php',
                type: 'GET',
                success: function(response) {
                    if (response !== 'No RFID found' && response.trim() !== '') {
                      
                        $('#rfid').val(response.trim());

                     
                        clearInterval(interval);
                        $.ajax({
                        url: '/clearRFID.php', 
                        type: 'POST',
                        success: function() {
                            console.log('RFID file cleared successfully.');
                        },
                        error: function(xhr) {
                            console.log('Error clearing RFID file:', xhr.responseText);
                        }
                    });

                        
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    });
</script>
@endpush
