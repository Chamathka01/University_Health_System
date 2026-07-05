<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;

class RegisterController extends Controller
{
    public function create()
    {
        return view('nurse.create-user');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:doctor,nurse',
            'email' => 'required|email|unique:registers,email',
        ]);

        Register::create([
            'role'     => $request->role,
            'email'    => strtolower($request->email),
        ]);

        return redirect('/nurse/users/create')->with('success', 'User created successfully. They can now sign in with Google.');
    }
}
