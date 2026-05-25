<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalRecord;
use App\Models\Register;

class Visit extends Model
{
    protected $fillable = [
        'student_id',
        'nurse_id',
        'doctor_id',
        'visit_date',
        'status'
    ];

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function student()
    {
        return $this->belongsTo(Register::class, 'student_id');
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
