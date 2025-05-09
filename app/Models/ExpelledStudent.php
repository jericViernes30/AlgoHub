<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpelledStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'student_name',
        'course',
    ];
}
