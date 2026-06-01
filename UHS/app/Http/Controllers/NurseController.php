<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Visit;
use Illuminate\Support\Facades\Session;

class NurseController extends Controller
{
    /* ===================== */
    /* DASHBOARD */
    /* ===================== */

    public function dashboard()
    {
        $pending = Visit::with(['student', 'medicalRecord'])
            ->where('status', 'prescription-ready')
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('nurse.dashboard', compact('pending'));
    }

    /* ===================== */
    /* SCAN STUDENT */
    /* ===================== */

    public function scanStudent(Request $request)
    {
        $request->validate([
            'regno' => 'required'
        ]);

        $student = Register::where('regno', $request->regno)
            ->where('role', 'student')
            ->first();

        if (!$student) {
            return response()->json([
                'error' => 'Student not found'
            ]);
        }

        return response()->json([
            'student' => $student
        ]);
    }

    /* ===================== */
    /* CREATE VISIT */
    /* ===================== */

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

        return redirect('/nurse/dashboard')
            ->with('success', 'Visit created successfully');
    }

    /* ===================== */
    /* COMPLETE VISIT */
    /* ===================== */

    public function completeVisit($id)
    {
        $visit = Visit::findOrFail($id);

        $visit->status = 'completed';
        $visit->save();

        return redirect()->back()
            ->with('success', 'Medicine issued successfully');
    }
}
