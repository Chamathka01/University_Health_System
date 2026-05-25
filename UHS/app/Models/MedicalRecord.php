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
        'notes'
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
