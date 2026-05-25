<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'student_id',
        'nurse_id',
        'doctor_id',
        'visit_date',
        'status'
    ];
}
