<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalRecord;

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
}
