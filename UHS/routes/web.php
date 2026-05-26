<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\StudentController;
use App\Models\Register;

//Route::get('/', function () {
    //return view('welcome');
//});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::post('/login', [LoginController::class, 'login'])->name('login.check');

Route::get('/users', function () {
    $users = Register::all();
    return view('users', ['users' => $users]);
});

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/doctor/dashboard', function () {
    return view('doctor.dashboard');
});

Route::get('/nurse/dashboard', function () {
    return view('nurse.dashboard');
});

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
});

Route::get('/nurse/scan', function () {
    return view('nurse.scan');
});

Route::get('/nurse/student/{regno}', [NurseController::class, 'showStudent']);

Route::get('/nurse/visit/create/{student_id}', [NurseController::class, 'createVisit']);

Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard']);
Route::get('/doctor/consult/{visit_id}', [DoctorController::class, 'consult']);
Route::post('/doctor/save-consultation', [DoctorController::class, 'saveConsultation']);

Route::get('/nurse/prescriptions', [NurseController::class, 'prescriptions']);
Route::get('/nurse/complete/{visit_id}', [NurseController::class, 'completeVisit']);

Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

Route::post('/nurse/search-student', [NurseController::class, 'searchStudent']);
