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
        $pending = Visit::with('student')
            ->where('status', 'prescription-ready')
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('nurse.dashboard', compact('pending'));
    }

    /* ===================== */
    /* SCAN STUDENT (AJAX) */
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

        $nurse = Session::get('user');

        // create visit when scanned
        $visit = Visit::create([
            'student_id' => $student->id,
            'nurse_id' => $nurse['id'],
            'doctor_id' => null,
            'visit_date' => now(),
            'status' => 'waiting'
        ]);

        return response()->json([
            'student' => $student,
            'visit' => $visit
        ]);
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
