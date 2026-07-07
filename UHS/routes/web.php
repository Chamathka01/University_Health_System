<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicineStockController;

//Auth pages

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return redirect('/login')->with('error', 'Please sign in with Google and select your role.');
});

Route::post('/register', function () {
    return redirect('/login')->with('error', 'Please sign in with Google and select your role.');
})->name('register.store');
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('login.google.callback');
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

    Route::get('/nurse/visit/create/{patient_nic}', [NurseController::class, 'createVisit']);

    Route::get('/nurse/complete/{id}', [NurseController::class, 'completeVisit']);

    Route::get('/nurse/users/create', [RegisterController::class, 'create'])->name('nurse.users.create');

    Route::post('/nurse/users', [RegisterController::class, 'store'])->name('nurse.users.store');
});

// Student + Staff Module

Route::middleware('role:student,staff')->group(function () {

    Route::get('/patient/dashboard', [PatientController::class, 'dashboard']);
});

Route::get('/forgot-password', function () {
    return redirect('/login')->with('error', 'Password reset is disabled. Please sign in with Google.');
});

Route::post('/forgot-password', function () {
    return redirect('/login')->with('error', 'Password reset is disabled. Please sign in with Google.');
})->name('password.send');

Route::get('/reset-password', function () {
    return redirect('/login')->with('error', 'Password reset is disabled. Please sign in with Google.');
});

Route::post('/reset-password', function () {
    return redirect('/login')->with('error', 'Password reset is disabled. Please sign in with Google.');
})->name('password.reset');

// Medicine Inventory Module (Accessible to Doctor and Nurse roles)
Route::middleware(['medical.staff'])->group(function () {
    Route::get('/medicine-stock', [MedicineStockController::class, 'index'])->name('stock.index');
    Route::post('/medicine-stock', [MedicineStockController::class, 'store'])->name('stock.store');
    Route::post('/medicine-stock/update/{id}', [MedicineStockController::class, 'update'])->name('stock.update');
});
