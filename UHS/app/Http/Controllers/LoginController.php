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
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = Register::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Session::put('user', $user);

            if ($user->role == 'doctor') {
                return redirect('/doctor/dashboard');
            }

            if ($user->role == 'nurse') {
                return redirect('/nurse/dashboard');
            }

            if ($user->role == 'student') {
                return redirect('/patient/dashboard');
            }

            if ($user->role == 'staff') {
                return redirect('/patient/dashboard');
            }

            return back()->with('error', 'Unknown role.');
        }
        return back()->with('error', 'Invalid email or password.')
                     ->withInput(['email' => $request->email]);
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }
}

