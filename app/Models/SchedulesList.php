<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulesList extends Model
{
    use HasFactory;

    protected $table = 'scheduling_lists';

    protected $fillable = [
        'parents_name',
        'childs_name',
        'age',
        'contact_number',
        'email_address',
        'status'
    ];

    public $timestamps = false;
}
