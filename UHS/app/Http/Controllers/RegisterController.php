<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:doctor,nurse,student,staff',
            'email' => 'required|email|unique:registers,email',
        ]);

        if ($request->role == 'student') {

            $request->validate([
                'regno' => 'required|string|max:20|unique:registers,regno',
            ]);
        }

        if ($request->role == 'staff') {
            $request->validate([
                'staff_id' => 'required|string|max:20|unique:registers,staff_id',
            ]);
        }

        Register::create([
            'role'     => $request->role,
            'email'    => strtolower($request->email),
            'password' => Hash::make(Str::random(32)),
            'regno'    => $request->role === 'student' ? $request->regno    : null,
            'staff_id' => $request->role === 'staff'   ? $request->staff_id : null,
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please sign in with Google using the same email.');
    }
}
