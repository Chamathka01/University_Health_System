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
        $pending = Visit::with(['patient', 'medicalRecord'])
            ->where('status', 'prescription-ready')
            ->whereDate('visit_date', now()->toDateString())
            ->orderBy('visit_date', 'desc')
            ->get();

        $totalPatientsCount = Visit::whereDate('visit_date', now()->toDateString())
                                    ->count();

        return view('nurse.dashboard', compact('pending','totalPatientsCount'));
    }

    // Scan students and staff

    public function scanPatient(Request $request)
    {
        $request->validate([
            'regno' => 'required'
        ]);

        $value = $request->regno;

        // Search by regno (students) OR staff_id (staff)

        $patient = Register::where(function ($q) use ($value) {
            $q->where('regno', $value)
                  ->orWhere('staff_id', $value);
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
                'role'       => $patient->role,
                'email'      => $patient->email,
                'display_id' => $patient->role == 'student' ? $patient->regno : $patient->staff_id,
            ]
        ]);
    }

    // Create Visit

    public function createVisit($patient_id)
    {
        $nurse = Session::get('user');

        Visit::create([
            'patient_id' => $patient_id,
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
