<?php

namespace App\Http\Controllers;

use App\Models\StudentStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Visit;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Session::get('user');
        $patient = StudentStaff::where('nic', $user['nic'] ?? null)->first();

        $visits = $patient
            ? Visit::with('medicalRecord')
                ->where('patient_nic', $patient->nic)
                ->orderBy('visit_date', 'desc')
                ->get()
            : collect();

        return view('patient.dashboard', compact('visits','user'));
    }
}
