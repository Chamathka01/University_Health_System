<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    protected $fillable = [
        'medical_record_id',
        'medicine_id',
        'quantity_per_dose',
        'frequency',
        'meal_timing',
        'duration_days',
        'quantity_given',
    ];

    public $timestamps = false;

    public $incrementing = false;

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
