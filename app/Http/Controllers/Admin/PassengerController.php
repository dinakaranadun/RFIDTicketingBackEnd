<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = User::where('user_type', 'USR')
            ->when($request->name, function ($query, $name) {
               return $query->where(DB::raw('CONCAT(fName, " ", lName)'), 'LIKE', '%' . $name . '%');
            })
            ->when($request->email, function ($query, $email) {
                return $query->where('email', 'LIKE', '%' . $email . '%');
            })
            ->when($request->NIC,function($query,$NIC){
                return $query->where('NIC','LIKE','%'.$NIC.'%');
            })
            ->paginate(10);
        return view('passenger.index', compact('passengers'));
    }

    public function create()
    {
        return view('passenger.create');
    }

    public function store(Request $request){

        $request->validate(
            [
                'fname' => 'required|string',
                'lname' => 'required|string',
                'email' => 'required|email|unique:users',
                'contact_number' => 'required|unique:users',
                'password' => 'required|confirmed|string|min:8',
                'nic' => 'required|string|max:12|unique:users',
            ],
            [],
            [
                'fname' => 'First Name',
                'lname' => 'Last Name',
                'email' => 'Email',
                'contact_number' => 'Contact Number',
                'password' => 'Password',
                'nic' => 'NIC',
            ]
        );

        $passenger = new User();
        $passenger->fName = $request->fname;
        $passenger->lName = $request->lname;
        $passenger->email = $request->email;
        $passenger->contact_number = $request->contact_number;
        $passenger->password = Hash::make($request->password);
        $passenger->NIC = $request->nic;
        $passenger->status = 'inactive';
        $passenger->user_type = 'USR';
        $passenger->save();

        return redirect()->route('passenger.index')->with('success', 'Passenger created successfully');

    }

    public function edit(User $passenger)
    {
        if ($passenger->user_type !== 'USR') {
            return redirect()->route('passenger.index')->with('error', 'Invalid passenger');
        }
        return view('passenger.edit', compact('passenger'));
    }
    
    public function update(User $passenger, Request $request)
    {
        if ($passenger->user_type !== 'USR') {
            return redirect()->route('passenger.index')->with('error', 'Invalid passenger');
        }
        $request->validate(
            [
                'fname' => 'required|string',
                'lname' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $passenger->id,
                'contact_number' => 'required|unique:users,contact_number,' . $passenger->id,
                'nic' => 'required|string|max:12|unique:users,NIC,' . $passenger->id,
                'rfid' => 'nullable|unique:users,rfid,' . $passenger->id,
            ],
            [],
            [
                'fname' => 'First Name',
                'lname' => 'Last Name',
                'email' => 'Email',
                'contact_number' => 'Contact Number',
                'nic' => 'NIC',
                'rfid' => 'RFID',
            ]
        );



        $passenger->fName = $request->fname;
        $passenger->lName = $request->lname;
        $passenger->email = $request->email;
        $passenger->contact_number = $request->contact_number;
        $passenger->NIC = $request->nic;
        $passenger->rfid = $request->rfid;
        $passenger->status = $request->status;
        $passenger->save();

        return redirect()->route('passenger.index')->with('success', 'Passenger updated successfully');
    }

}
