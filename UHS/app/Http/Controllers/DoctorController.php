<?php

namespace App\Http\Controllers;

use App\Models\Visit;

use Illuminate\Http\Request;

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
}
