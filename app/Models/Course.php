<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory; 
    protected $table = 'course';

    protected $fillable = [
        'course_ID',
        'course_name',
        'teacher',
        'teacher_id',
        'day',
        'time_slot',
        'start_date'
    ];
}
