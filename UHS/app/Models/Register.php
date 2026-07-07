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
        'role',
        'email',
    ];

    public function isPatient(): bool
    {
        return in_array($this->role, ['student', 'staff']);
    }

    // Returns the display ID used across dashboards.
    public function getDisplayIdAttribute(): string
    {
        return $this->email ?? 'N/A';
    }

    // Returns the value to encode in barcode
    public function getBarcodeValueAttribute(): string
    {
        return $this->email ?? (string) $this->id;
    }

    // Display name: use the ID since we no longer collect name
    public function getDisplayNameAttribute(): string
    {
        return $this->display_id;
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
