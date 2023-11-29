<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'medical_histories';

    protected $fillable = [
        'treatment_plan',
        'admission_date',
        'clinical_evaluation',
        'current_problematic_description',
        'medical_history',
        'psychological_history',
        'medication',
        'provisional_diagnosis',
        'traumatic_experiences',
        'psychosocial_history',
        'substance_consumption',
        'ailments'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
