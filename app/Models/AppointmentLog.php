<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    
    public $timestamps = 'created_at';

    protected $table = 'appointments_log';

    protected $fillable = [
        'user_id',
        'action',
        'details'
    ];
}
