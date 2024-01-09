<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments';

    protected $fillable = [
        'psychologist_user_id',
        'patient_user_id',
        'reason_inquiry',
        'note',
        'preferred_datetime',
        'way_pay',
        'state'
    ];
}
