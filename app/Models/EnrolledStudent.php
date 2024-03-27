<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrolledStudent extends Model
{
    use HasFactory;

    protected $table = 'enrolled_students';

    protected $fillable = [
        'student_name',
        'course_name',
        'day',
        'time_slot',
        'enrollment_date'
    ];

    public static function create(array $attributes = [])
    {
        $model = new static($attributes);
        $model->enrollment_date = now(); // Set the created_date value
        $model->fill($attributes);
        $model->save();
        

        return $model;
    }

    public $timestamps = false;
}
