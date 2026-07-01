<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\MedicalRecord;
use App\Models\Medicine;
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

        $monthlyVisitsLog = Visit::with('patient')
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
                ->where('patient_id', $visit->patient_id)
                ->where('id', '!=', $visit->id)
                ->whereNotNull('doctor_id')
                ->orderBy('visit_date', 'desc')
                ->get();

    // Pass the list of available medicines down to the form dropdown selection map
    $availableMedicines = \App\Models\Medicine::where('stock_quantity', '>', 0)
                                    ->orderBy('name', 'asc')
                                    ->get();

    return view('doctor.consult', compact('visit','history','availableMedicines'));
}

    public function saveConsultation(Request $request)
{
    $request->validate([
        'visit_id' => 'required',
        'diagnosis' => 'required',
        'prescription' => 'required',
        'medicine_id'    => 'required|exists:medicines,id',
        'quantity_given' => 'required|integer|min:1',
        'report' => 'nullable|file|mimes:pdf|max:5120',
    ]);

    $doctor = Session::get('user');

    // Handle PDF upload
        $reportPath = null;
        if ($request->hasFile('report') && $request->file('report')->isValid()) {
            $reportPath = $request->file('report')
                            ->store('reports', 'public');
        }

    try {
            DB::transaction(function () use ($request, $reportPath, $doctor) {

                // 1. Fetch the medicine from stock to verify current inventory status
                $medicine = Medicine::findOrFail($request->medicine_id);

                if ($medicine->stock_quantity < $request->quantity_given) {
                    throw new \Exception("Insufficient stock available! Only {$medicine->stock_quantity} units left of {$medicine->name}.");
                }

                // 2. Decrement the inventory quantities automatically
                $medicine->decrement('stock_quantity', $request->quantity_given);

                // 3. Format prescription output string safely to log inside medical history records
                $prescriptionString = $medicine->name . " (Qty: " . $request->quantity_given . " units)";

                // 4. Record the medical consultation log details
                MedicalRecord::create([
                    'visit_id'     => $request->visit_id,
                    'diagnosis'    => $request->diagnosis,
                    'prescription' => $prescriptionString, // Automatically formatted descriptive entry
                    'notes'        => $request->notes,
                    'report_path'  => $reportPath,
                ]);

                // 5. Upgrade visit dispatch workflow states
                $visit = Visit::findOrFail($request->visit_id);
                $visit->doctor_id = $doctor['id'];
                $visit->status = 'prescription-ready';
                $visit->save();
            });

            return redirect('/doctor/dashboard')
                    ->with('success', 'Consultation saved and medicine inventory count adjusted successfully.');

        } catch (\Exception $e) {
            // Revert paths uploaded if database interactions fails mid-execution
            if ($reportPath) {
                Storage::disk('public')->delete($reportPath);
            }

            return back()->with('error', $e->getMessage())->withInput();
        }
    }
}
