<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentStaff extends Model
{
    protected $table = 'student_staff';

    protected $primaryKey = 'nic';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nic',
        'name',
        'reg_no',
        'role',
        'enrollment_date',
        'gender',
        'city',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
    ];

    public function getDisplayIdAttribute(): string
    {
        return $this->role === 'student' && $this->reg_no
            ? $this->reg_no
            : $this->nic;
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'patient_nic', 'nic');
    }
}
