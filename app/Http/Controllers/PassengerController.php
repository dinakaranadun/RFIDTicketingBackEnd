<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PassengerController extends Controller
{
    
   
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
        $user->rfid = null;
        $user->account_credits = 0.00;
        $user->status = 'inactive';
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
  


    public function update(string $id, Request $request)
    {
        $request->validate([
            'fName' => 'required|string',
            'lName' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id), 
            ],
            'contact_number' => 'required|string|max:10',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->fName = $request->input('fName');
        $user->lName = $request->input('lName');
        $user->email = $request->input('email');
        $user->contact_number = $request->input('contact_number');
        $user->updated_at = Carbon::now();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User updated Successfully".',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updatePassword(string $id, Request $request){
        $request->validate([
            'currentUserPassword' => 'required|string',
            'password' => 'required|string|min:8',
        ]);
    
       
        $user = User::find($id);
    
       
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        
        if (!Hash::check($request->input('currentUserPassword'), $user->password)) {
            return response()->json(['message' => 'Current Password is incorrect'], 400);
        }
    
        $user->password = Hash::make($request->input('password'));
        $user->save();
    
        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

    public function uploadProfileImage(string $id,Request $request,)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $imagePath = 'images/uploads/'.$imageName;

        // Save image in the public folder
        $image->move(public_path('images/uploads'), $imageName);

        // Store the image path in the database
        $user = User::find($id);
        $user->image_URL = $imagePath;
        $user->save();

        return response()->json([
            'success' => true,
            'imagePath' => $imagePath,
        ]);
    }

    
}
