<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Visit;

class StudentController extends Controller
{
    public function dashboard()
    {
        $student = Session::get('user');

        $visits = Visit::with('medicalRecord')
                    ->where('student_id', $student->id)
                    ->orderBy('visit_date', 'desc')
                    ->get();

        return view('student.dashboard', compact('visits'));
    }
}
