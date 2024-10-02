<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'registered_college_students';

    protected $fillable = [
        'firstname',
        'middleinitial',
        'lastname',
        'birthday',
        'email',
        'idnumber',
        'courseyear',
        'address',
        'contactperson',
        'contactnumber',
        'idpicture',
        'signature',
        'payment'
    ];
}
