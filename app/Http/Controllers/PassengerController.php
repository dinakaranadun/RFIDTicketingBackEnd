<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PassengerController extends Controller
{
    // Generate sequential RFID
    private function generateRFID() {
        $prefix = 'RFID';
        $length = 10; 

        $lastUser = User::orderBy('id', 'desc')->first();
        $lastRFID = ($lastUser) ? $lastUser->rfid : null;

        $lastNumber = ($lastRFID) ? (int) substr($lastRFID, strlen($prefix)) : 0;


        $nextNumber = $lastNumber + 1;

        $paddedNumber = str_pad($nextNumber, $length, '0', STR_PAD_LEFT);

    
        $rfid = $prefix . $paddedNumber;

        return $rfid;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'NIC' => 'required|string|max:12|unique:users',
            'contact_number' => 'required|string|max:10',
        ]);

        $user = new User();
        $user->fName = $request->input('first_name');
        $user->lName = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->NIC = $request->input('NIC');
        $user->contact_number = $request->input('contact_number');
        $user->image = null;
        $user->rfid = $this->generateRFID();
        $user->account_credits = 0.00;
        $user->status = 'active';
        $user->remember_token = null;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        $user->contactnumber_verified_at = Carbon::now();


        $user->save();

        return response()->json(['message' => 'User created successfully'], 201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
