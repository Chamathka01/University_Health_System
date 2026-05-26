<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Visit;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\Session;

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

    public function createVisit($student_id)
    {
        $nurse = Session::get('user');

        Visit::create([
            'student_id' => $student_id,
            'nurse_id' => $nurse['id'],
            'doctor_id' => null,
            'visit_date' => now(),
            'status' => 'waiting'
        ]);

        return redirect('/nurse/scan')
            ->with('success', 'Visit created successfully');
    }

    public function prescriptions()
    {
    $visits = Visit::with(['student', 'medicalRecord'])
                ->where('status', 'prescription_ready')
                ->get();

    return view('nurse.prescriptions', compact('visits'));
    }

    public function completeVisit($visit_id)
    {
    $visit = Visit::findOrFail($visit_id);

    $visit->status = 'completed';

    $visit->save();

    return redirect('/nurse/prescriptions')
            ->with('success', 'Medicine issued successfully');
    }
}
