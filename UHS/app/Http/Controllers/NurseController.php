<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Register;
use App\Models\Visit;
use Illuminate\Support\Facades\Session;

class NurseController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $pending = Visit::with(['student', 'medicalRecord'])
            ->where('status', 'prescription-ready')
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('nurse.dashboard', compact('pending'));
    }

    // Scan students and staff

    public function scanStudent(Request $request)
    {
        $request->validate([
            'regno' => 'required'
        ]);

        $searchValue = $request->regno;

        // Search by regno (students) OR staff_id (staff)

        $patient = Register::where(function ($query) use ($searchValue) {
            $query->where('regno', $searchValue)
                  ->orWhere('staff_id', $searchValue);
            })
            ->whereIn('role', ['student','staff'])
            ->first();

        if (!$patient) {
            return response()->json([
                'error' => 'Patient not found. Check the ID and try again.'
            ]);
        }

        return response()->json([
            'patient' => [
                'id'         => $patient->id,
                'name'       => $patient->full_name,
                'display_id' => $patient->display_id,
                'role'       => $patient->role,
                'email'      => $patient->email,
                'phone'      => $patient->phone,
                'faculty'    => $patient->faculty,
                'department' => $patient->staff_department ?? $patient->department,
            ]
        ]);
    }

    // Create Visit

    public function createVisit($patient_id)
    {
        $nurse = Session::get('user');

        Visit::create([
            'student_id' => $patient_id,
            'nurse_id' => $nurse['id'],
            'doctor_id' => null,
            'visit_date' => now(),
            'status' => 'waiting'
        ]);

        return redirect('/nurse/dashboard')
            ->with('success', 'Visit created successfully');
    }

    // Complete Visit

    public function completeVisit($id)
    {
        $visit = Visit::findOrFail($id);

        $visit->status = 'completed';
        $visit->save();

        return redirect()->back()
            ->with('success', 'Medicine issued successfully');
    }
}
