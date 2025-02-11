<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_name',
        'first_name',
        'email_address',
        'contact_number',
        'username',
        'password',
    ];
}
