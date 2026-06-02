<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Visit;

class MedicalRecord extends Model
{
    protected $fillable = [
        'visit_id',
        'diagnosis',
        'prescription',
        'notes',
        'report_path',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    // Returns full public URL for the PDF
    public function getReportUrlAttribute(): ?string
    {
        if ($this->report_path) {
            return asset('storage/' . $this->report_path);
        }
        return null;
    }
}
