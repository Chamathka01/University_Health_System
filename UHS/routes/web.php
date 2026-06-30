<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ForgotPasswordController;
use App\Models\Register;

//Auth pages

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::post('/login', [LoginController::class, 'login'])->name('login.check');
Route::get('/logout', [LoginController::class, 'logout']);

// Doctor Module

Route::middleware('role:doctor')->group(function () {

    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);

    Route::get('/doctor/consult/{id}', [DoctorController::class, 'consult']);

    Route::post('/doctor/save-consultation', [DoctorController::class, 'saveConsultation']);
});

// Nurse Module

Route::middleware('role:nurse')->group(function () {

    Route::get('/nurse/dashboard', [NurseController::class, 'dashboard']);

    Route::post('/nurse/scan', [NurseController::class, 'scanPatient']);

    Route::get('/nurse/visit/create/{patient_id}', [NurseController::class, 'createVisit']);

    Route::get('/nurse/complete/{id}', [NurseController::class, 'completeVisit']);
});

// Student + Staff Module

Route::middleware('role:student,staff')->group(function () {

    Route::get('/patient/dashboard', [PatientController::class, 'dashboard']);
});

// Forgot Password

// show forgot password form
Route::get('/forgot-password', function () {
    return view('forgot-password');
});

// send OTP
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendLink'])
    ->name('password.send');

// reset password form
Route::get('/reset-password', function () {
    return view('reset-password');
});

// reset password action
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.reset');
