<?php

namespace App\Http\Controllers;

use App\Models\StudentStaff;
use Illuminate\Http\Request;

class PatientSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q'));
        $patient = null;

        if ($query !== '') {
            $patient = StudentStaff::with([
                'visits' => function ($visitQuery) {
                    $visitQuery->with([
                        'nurse',
                        'doctor',
                        'medicalRecord.prescriptionItems.medicine',
                    ])->orderBy('visit_date', 'desc');
                },
            ])
                ->where('nic', $query)
                ->orWhere('reg_no', $query)
                ->first();
        }

        return view('patient-search', [
            'query' => $query,
            'patient' => $patient,
        ]);
    }
}
