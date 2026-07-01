<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;

class MedicineStockController extends Controller
{
    public function index()
    {
        $medicines = Medicine::orderBy('name', 'asc')->get();

        $expiredCount = Medicine::where('expiry_date', '<', now()->toDateString())->count();

        $nearExpiryCount = Medicine::where('expiry_date', '>=', now()->toDateString())
                        ->where('expiry_date', '<=', now()->addDays(30)->toDateString())
                        ->count();

        $lowStockCount = Medicine::where('stock_quantity', '>', 0)
                        ->whereRaw('stock_quantity <= min_required_alert')
                        ->count();

        return view('medicine-stock', compact('medicines','expiredCount', 'nearExpiryCount', 'lowStockCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'batch_number' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'min_required_alert' => 'required|integer|min:0',
            'expiry_date' => 'required|date',
        ]);

        Medicine::create($request->all());

        return redirect()->back()->with('success', 'Medicine stock registered successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->update([
            'stock_quantity' => $request->stock_quantity
        ]);

        return redirect()->back()->with('success', 'Stock inventory metrics updated accurately.');
    }
}
