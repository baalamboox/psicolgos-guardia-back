<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmergencyContact extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emergency_contacts';

    protected $fillable = [
        'names',
        'first_surname',
        'second_surname',
        'relationship',
        'address',
        'phone',
        'whatsapp'
    ];
}
