<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $visits = Visit::with('patient')
                    ->whereIn('status', ['waiting', 'in-progress'])
                    ->whereMonth('visit_date', now()->month)
                    ->whereYear('visit_date', now()->year)
                    ->orderBy('visit_date')
                    ->get();

        $monthlyVisitsLog = Visit::with(['patient', 'medicalRecord'])
                    ->whereMonth('visit_date', now()->month)
                    ->whereYear('visit_date', now()->year)
                    ->orderBy('visit_date', 'desc')
                    ->get();

        return view('doctor.dashboard', compact('visits', 'monthlyVisitsLog'));
    }

    public function consult($visit_id)
{
    $visit = Visit::with('patient')->findOrFail($visit_id);

    if ($visit->status == 'waiting') {

        $visit->status = 'in-progress';

        $visit->save();
    }

    $history = Visit::with('medicalRecord')
                ->where('patient_nic', $visit->patient_nic)
                ->where('id', '!=', $visit->id)
                ->whereNotNull('doctor_id')
                ->orderBy('visit_date', 'desc')
                ->get();

    // Pass the list of available medicines down to the form dropdown selection map
    $availableMedicines = Medicine::where('stock_quantity', '>', 0)
                                    ->orderBy('name', 'asc')
                                    ->get();

    return view('doctor.consult', compact('visit','history','availableMedicines'));
}

    public function saveConsultation(Request $request)
{
    $request->validate([
        'visit_id'       => 'required',
        'diagnosis'      => 'required',
        'icd10_code' => 'nullable|string|max:20',
        'icd10_description' => 'nullable|string|max:255',
        'medicine_id'    => 'required|array|min:1',
        'medicine_id.*'  => 'required|exists:medicines,id',
        'quantity_per_dose' => 'required|array|min:1',
        'quantity_per_dose.*' => 'required|integer|min:1',
        'frequency' => 'required|array|min:1',
        'frequency.*' => 'required|in:OD,BD,TDS,QID',
        'meal_timing' => 'required|array|min:1',
        'meal_timing.*' => 'required|in:AC,PC',
        'duration_days' => 'required|array|min:1',
        'duration_days.*' => 'required|integer|min:1',
        'report'         => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $doctor = Session::get('user');

    // Handle PDF upload
    $reportPath = null;
    if ($request->hasFile('report') && $request->file('report')->isValid()) {
        $reportPath = $request->file('report')->store('reports', 'public');
    }

    try {
        DB::transaction(function () use ($request, $reportPath, $doctor) {

            $prescriptionLines = [];
            $prescriptionItems = [];

            foreach ($request->medicine_id as $index => $medicineId) {
                $quantityPerDose = (int) ($request->quantity_per_dose[$index] ?? 0);
                $frequency = $request->frequency[$index] ?? '';
                $mealTiming = $request->meal_timing[$index] ?? '';
                $durationDays = (int) ($request->duration_days[$index] ?? 0);
                $dosesPerDay = $this->dosesPerDay($frequency);
                $quantityGiven = $quantityPerDose * $dosesPerDay * $durationDays;
                $medicine = Medicine::findOrFail($medicineId);

                if ($medicine->stock_quantity < $quantityGiven) {
                    throw new \Exception("Insufficient stock available! Only {$medicine->stock_quantity} units left of {$medicine->name}.");
                }

                $medicine->decrement('stock_quantity', $quantityGiven);
                $prescriptionLines[] = "{$medicine->name} - {$quantityPerDose} per meal, {$frequency}, {$mealTiming}, {$durationDays} days";
                $prescriptionItems[] = [
                    'medicine_id' => $medicine->id,
                    'quantity_per_dose' => $quantityPerDose,
                    'frequency' => $frequency,
                    'meal_timing' => $mealTiming,
                    'duration_days' => $durationDays,
                    'quantity_given' => $quantityGiven,
                ];
            }

            $prescriptionString = implode("\n", $prescriptionLines);

            $medicalRecord = MedicalRecord::create([
                'visit_id'     => $request->visit_id,
                'diagnosis'    => $request->diagnosis,
                'icd10_code' => $request->icd10_code,
                'icd10_description' => $request->icd10_description,
                'prescription' => $prescriptionString,
                'notes'        => $request->notes,
                'report_path'  => $reportPath,
            ]);

            foreach ($prescriptionItems as $item) {
                PrescriptionItem::create($item + [
                    'medical_record_id' => $medicalRecord->id,
                ]);
            }

            $visit = Visit::find($request->visit_id);
            $visit->doctor_id = $doctor['id'];
            $visit->status = 'prescription-ready';
            $visit->save();
        });

        return redirect('/doctor/dashboard')
                ->with('success', 'Consultation saved and medicine stock updated successfully.');

    } catch (\Exception $e) {
        if ($reportPath) {
            Storage::disk('public')->delete($reportPath);
        }

        return back()->with('error', $e->getMessage())->withInput();
    }
}

    private function dosesPerDay(string $frequency): int
    {
        return match ($frequency) {
            'OD' => 1,
            'BD' => 2,
            'TDS' => 3,
            'QID' => 4,
            default => 1,
        };
    }

}
