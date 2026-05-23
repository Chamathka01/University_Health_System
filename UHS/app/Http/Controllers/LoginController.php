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

            if ($user->role == 'admin') {
                return redirect('/users');
            } else {
                return redirect('/home');
            }

        }

        return back()->with('error', 'Invalid Login');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }
}
