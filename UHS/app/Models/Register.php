<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Visit;

class Register extends Model
{
    use HasFactory;

    protected $table = 'registers';

    protected $fillable = [
        'firstname',
        'lastname',
        'dob',
        'phone',
        'email',
        'username',
        'role',
        'password',
        // Student fields
        'faculty',
        'department',
        'degree',
        'regno',
        // Staff fields
        'staff_id',
        'staff_department',
    ];

    // Returns the display ID (regno for students, staff_id for staff)
    public function getDisplayIdAttribute(): string
    {
        return $this->regno ?? $this->staff_id ?? 'N/A';
    }

    // Returns full name
    public function getFullNameAttribute(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    // Returns the value to encode in barcode
    public function getBarcodeValueAttribute(): string
    {
        return $this->regno ?? $this->staff_id ?? (string) $this->id;
    }

    public function studentvisits()
    {
    return $this->hasMany(Visit::class, 'student_id');
    }

    public function nurseVisits()
    {
    return $this->hasMany(Visit::class, 'nurse_id');
    }

    public function doctorVisits()
    {
    return $this->hasMany(Visit::class, 'doctor_id');
    }
}
