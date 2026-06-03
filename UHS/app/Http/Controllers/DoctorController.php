<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $visits = Visit::with('patient')
                    ->where('status', ['waiting', 'in-progress'])
                    ->orderBy('visit_date')
                    ->get();

        return view('doctor.dashboard', compact('visits'));
    }

    public function consult($visit_id)
{
    $visit = Visit::with('patient')->findOrFail($visit_id);

    if ($visit->status == 'waiting') {

        $visit->status = 'in-progress';

        $visit->save();
    }

    $history = Visit::with('medicalRecord')
                ->where('patient_id', $visit->patient_id)
                ->where('id', '!=', $visit->id)
                ->whereNotNull('doctor_id')
                ->orderBy('visit_date', 'desc')
                ->get();

    return view('doctor.consult', compact('visit','history'));
}

    public function saveConsultation(Request $request)
{
    $request->validate([
        'visit_id' => 'required',
        'diagnosis' => 'required',
        'prescription' => 'required',
        'report' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $doctor = Session::get('user');

    // Handle PDF upload
        $reportPath = null;
        if ($request->hasFile('report') && $request->file('report')->isValid()) {
            $reportPath = $request->file('report')
                            ->store('reports', 'public');
        }

    MedicalRecord::create([
        'visit_id' => $request->visit_id,
        'diagnosis' => $request->diagnosis,
        'prescription' => $request->prescription,
        'notes' => $request->notes,
        'report_path'  => $reportPath,
    ]);

    $visit = Visit::find($request->visit_id);

    $visit->doctor_id = $doctor['id'];
    $visit->status = 'prescription-ready';
    $visit->save();

    return redirect('/doctor/dashboard')
            ->with('success', 'Consultation saved successfully');
}
}
