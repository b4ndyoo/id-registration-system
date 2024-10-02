<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchiveStudent extends Model
{
    use HasFactory;

    protected $table = 'archives_college';

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
