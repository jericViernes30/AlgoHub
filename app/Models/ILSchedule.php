<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ILSchedule extends Model
{
    use HasFactory;

    protected $table = 'all_il_schedules';

    public $timestamps = false;

    protected $fillable = [
        'code',
        'course',
        'teacher',
        'day',
        'from',
        'to'
    ];

    public function il_students()
    {
        return $this->hasMany(ILStudents::class, 'code', 'code');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher', 'id');
    }
}
