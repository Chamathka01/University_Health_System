<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Visit;

class PatientController extends Controller
{
    public function dashboard()
    {
        $user = Session::get('user');

        $visits = Visit::with('medicalRecord')
                    ->where('patient_id', $user['id'])
                    ->orderBy('visit_date', 'desc')
                    ->get();

        return view('patient.dashboard', compact('visits','user'));
    }
}
