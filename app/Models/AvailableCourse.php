<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableCourse extends Model
{
    use HasFactory;
    protected $table = 'available_courses';
    
    protected $fillable = [
        'course_name'
    ];
}
