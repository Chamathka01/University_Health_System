<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Visit;

class NurseController extends Controller
{
    public function showStudent($regno)
    {
        // 1. Find student by barcode (regno)
        $student = Register::where('regno', $regno)
                    ->where('role', 'student')
                    ->first();

        // 2. If not found
        if (!$student) {
            return redirect('/nurse/scan')
                ->with('error', 'Student not found');
        }

        // 3. Get previous visits
        $visits = Visit::where('student_id', $student->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        // 4. Send to view
        return view('nurse.student_profile', compact('student', 'visits'));
    }
}
