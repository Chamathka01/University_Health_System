<?php

namespace App\Http\Controllers;

use App\Models\Visit;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $visits = Visit::with('student')
                    ->where('status', 'waiting')
                    ->orderBy('visit_date')
                    ->get();

        return view('doctor.dashboard', compact('visits'));
    }

    public function consult($visit_id)
{
    $visit = Visit::with('student')->findOrFail($visit_id);

    return view('doctor.consult', compact('visit'));
}

    public function saveConsultation(Request $request)
{
    $request->validate([
        'visit_id' => 'required',
        'diagnosis' => 'required',
        'prescription' => 'required'
    ]);

    $doctor = Session::get('user');

    MedicalRecord::create([
        'visit_id' => $request->visit_id,
        'diagnosis' => $request->diagnosis,
        'prescription' => $request->prescription,
        'notes' => $request->notes
    ]);

    $visit = Visit::find($request->visit_id);

    $visit->doctor_id = $doctor['id'];
    $visit->status = 'prescription_ready';
    $visit->save();

    return redirect('/doctor/dashboard')
            ->with('success', 'Consultation saved successfully');
}
}
