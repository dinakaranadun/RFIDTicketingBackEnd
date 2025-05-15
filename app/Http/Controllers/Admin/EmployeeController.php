<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::where('user_type', 'EMP')
            ->when($request->name, function ($query, $name) {
               return $query->where(DB::raw('CONCAT(fName, " ", lName)'), 'LIKE', '%' . $name . '%');
            })
            ->when($request->email, function ($query, $email) {
                return $query->where('email', 'LIKE', '%' . $email . '%');
            })
            ->paginate(10);
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(Request $request)
    {
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

        $emp = new User();
        $emp->fName = $request->fname;
        $emp->lName = $request->lname;
        $emp->email = $request->email;
        $emp->contact_number = $request->contact_number;
        $emp->password = Hash::make($request->password);
        $emp->NIC = $request->nic;
        $emp->user_type = 'EMP';
        $emp->save();

        return redirect()->route('employee.index')->with('success', 'Employee added successfully');
    }

    public function edit(User $employee)
    {
        if ($employee->user_type !== 'EMP') {
            return redirect()->route('employee.index')->with('error', 'Invalid employee');
        }
        return view('employee.edit', compact('employee'));
    }

    public function update(User $employee, Request $request)
    {
        if ($employee->user_type !== 'EMP') {
            return redirect()->route('employee.index')->with('error', 'Invalid employee');
        }
        $request->validate(
            [
                'fname' => 'required|string',
                'lname' => 'required|string',
                'email' => 'required|email|unique:users,email,' . $employee->id,
                'contact_number' => 'required|unique:users,contact_number,' . $employee->id,
                'nic' => 'required|string|max:12|unique:users,NIC,' . $employee->id,
            ],
            [],
            [
                'fname' => 'First Name',
                'lname' => 'Last Name',
                'email' => 'Email',
                'contact_number' => 'Contact Number',
                'nic' => 'NIC',
            ]
        );

        $employee->fName = $request->fname;
        $employee->lName = $request->lname;
        $employee->email = $request->email;
        $employee->contact_number = $request->contact_number;
        $employee->NIC = $request->nic;
        $employee->save();

        return redirect()->route('employee.index')->with('success', 'Employee updated successfully');
    }

    public function destroy(User $employee)
    {
        if ($employee->user_type !== 'EMP') {
            return redirect()->route('employee.index')->with('error', 'Invalid employee');
        }
        $employee->delete();
        return redirect()->route('employee.index')->with('success', 'Employee deleted successfully');
    }
}
