<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/login')->with('error', 'Google sign in failed. Please try again.');
        }

        $email = strtolower($googleUser->getEmail());

        $user = Register::where('email', $email)->first();

        if (!$user) {
            return redirect('/login')
                ->with('error', 'This Google account is not registered in the University Health System.');
        }

        Session::put('user', $user);

        return $this->redirectByRole($user);
    }

    private function redirectByRole(Register $user)
    {
        if ($user->role == 'doctor') {
            return redirect('/doctor/dashboard');
        }

        if ($user->role == 'nurse') {
            return redirect('/nurse/dashboard');
        }

        if ($user->role == 'student' || $user->role == 'staff') {
            return redirect('/patient/dashboard');
        }

        return redirect('/login')->with('error', 'Unknown role.');
    }

    public function login()
    {
        return redirect()->route('login.google');
    }

    public function logout()
    {
        Session::forget('user');
        return redirect('/login');
    }
}
