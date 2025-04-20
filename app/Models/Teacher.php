<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile',
        'certificates',
        'last_name',
        'first_name',
        'email_address',
        'contact_number',
        'certified_courses',
        'username',
        'password',
    ];
}
