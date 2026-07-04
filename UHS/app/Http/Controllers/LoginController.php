<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class LoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect('/login')->with('error', 'Google sign in failed. Please try again.');
        }

        $email = strtolower($googleUser->getEmail());

        Session::put('google_registration', [
            'email' => $email,
        ]);

        return redirect('/select-role')
            ->with('success', 'Google account verified. Please select your role to continue.');
    }

    public function showRoleSelection()
    {
        if (!Session::has('google_registration.email')) {
            return redirect('/login')->with('error', 'Please sign in with Google first.');
        }

        return view('select-role', [
            'email' => Session::get('google_registration.email'),
        ]);
    }

    public function storeRoleSelection(Request $request)
    {
        $email = Session::get('google_registration.email');

        if (!$email) {
            return redirect('/login')->with('error', 'Please sign in with Google first.');
        }

        $request->validate([
            'role' => 'required|in:doctor,nurse,student,staff',
        ]);

        $existingUser = Register::where('email', $email)->first();

        $user = Register::updateOrCreate([
            'email' => $email,
        ], [
            'role' => $request->role,
            'password' => $existingUser?->password ?? Hash::make(Str::random(32)),
            'regno' => null,
            'staff_id' => null,
        ]);

        Session::forget('google_registration');
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
        Session::forget('google_registration');
        return redirect('/login');
    }
}
