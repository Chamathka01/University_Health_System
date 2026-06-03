<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalRecord;
use App\Models\Register;

class Visit extends Model
{
    protected $fillable = [
        'patient_id',
        'nurse_id',
        'doctor_id',
        'visit_date',
        'status'
    ];

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function patient()
    {
        return $this->belongsTo(Register::class, 'patient_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Register::class, 'nurse_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Register::class, 'doctor_id');
    }
}
