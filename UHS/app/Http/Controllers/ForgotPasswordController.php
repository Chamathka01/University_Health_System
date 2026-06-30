<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
     public function sendLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = Register::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        // Generate 6-digit code
        $code = rand(100000, 999999);

        $user->reset_code = $code;
        $user->reset_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        // SEND EMAIL
        Mail::to($user->email)->send(new SendOtpMail($code));


        return redirect('/reset-password')->with('success', 'OTP sent to your email');
    }

    // RESET PASSWORD
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = Register::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        if ($user->reset_code !== $request->code) {
            return back()->with('error', 'The OTP code you entered is incorrect.');
        }

        // Check expiry
        if (Carbon::now()->gt($user->reset_expires_at)) {
            return back()->with('error', 'Code expired');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->reset_code = null;
        $user->reset_expires_at = null;
        $user->save();

        return redirect('/login')->with('success', 'Password updated successfully');
}
}
