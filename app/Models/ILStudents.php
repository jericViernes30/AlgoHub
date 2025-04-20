<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ILStudents extends Model
{
    use HasFactory;

    protected $table = 'il_students';
    protected $fillable = [
        'student_number',
        'code',
        'course',
        'student_name',
        'parent_name',
        'age',
        'contact_number',
        'email_address',
        'status'
    ];

    public function il_schedule()
{
    return $this->belongsTo(ILSchedule::class, 'code', 'code');
}

}
