<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
        public function login(Request $request)
        {
            $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = Register::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Session::put('user', $user);

            if ($user->role == 'doctor') {
                return redirect('/doctor/dashboard');
            }

            if ($user->role == 'nurse') {
                return redirect('/nurse/dashboard');
            }

            if ($user->role == 'student') {
                return redirect('/student/dashboard');
            }

            if ($user->role == 'staff') {
                return redirect('/student/dashboard');
            }

            return back()->with('error', 'Invalid username or password.');
        }
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }
}

