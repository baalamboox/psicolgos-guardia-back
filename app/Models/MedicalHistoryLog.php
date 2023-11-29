<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistoryLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    
    public $timestamps = 'created_at';

    protected $table = 'medical_histories_log';

    protected $fillable = [
        'medical_history_id',
        'user_id',
        'action',
        'details'
    ];
}
