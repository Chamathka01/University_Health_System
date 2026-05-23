<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'faculty',
        'department',
        'regno',
    ];
}
