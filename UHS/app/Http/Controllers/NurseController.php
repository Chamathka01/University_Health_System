<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\StudentStaff;
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

        $todaysVisits = Visit::with(['patient', 'medicalRecord'])
            ->whereDate('visit_date', now()->toDateString())
            ->orderBy('visit_date', 'desc')
            ->get();

        return view('nurse.dashboard', compact('pending','todaysVisits'));
    }

    // Scan students and staff

    public function scanPatient(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
            'detected_role' => 'required|in:student,staff',
        ]);

        $barcode = trim($request->barcode);
        $role = $request->detected_role;

        $patient = $role === 'student'
            ? StudentStaff::where('role', 'student')->where('reg_no', $barcode)->first()
            : StudentStaff::where('role', 'staff')->where('nic', $barcode)->first();

        if (! $patient) {
            return response()->json([
                'error' => ucfirst($role) . ' record was not found in the student/staff database.'
            ], 404);
        }

        return response()->json([
            'patient' => [
                'id' => $patient->nic,
                'nic' => $patient->nic,
                'name' => $patient->name,
                'display_id' => $patient->display_id,
                'role' => $patient->role,
                'gender' => $patient->gender,
                'city' => $patient->city,
            ]
        ]);
    }

    // Create Visit

    public function createVisit($patient_nic)
    {
        $nurse = Session::get('user');
        $patient = StudentStaff::where('nic', $patient_nic)->firstOrFail();

        Visit::create([
            'patient_id' => null,
            'patient_nic' => $patient->nic,
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
