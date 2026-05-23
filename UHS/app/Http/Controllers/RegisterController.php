<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'dob' => 'nullable|date',
            'phone' => 'nullable|digits:10',
            'email' => 'required|email|unique:registers,email',
            'username' => 'required|min:4|max:20|unique:registers,username',
            'role' => 'required|in:doctor,nurse,student',
            'password' => 'required|min:8',
            //'faculty' => 'required|in:doctor,nurse,student',
            //'department' => 'required|in:doctor,nurse,student',
            //'degree' => 'required|in:doctor,nurse,student',
            'regno' => 'required|string|max:20',
        ]);

        $user = new Register();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->dob = $request->dob;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->faculty = $request->faculty;
        $user->department = $request->department;
        $user->degree = $request->degree;
        $user->regno = $request->regno;

        $user->save();

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}
