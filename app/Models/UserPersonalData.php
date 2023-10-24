<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPersonalData extends Model
{
    use HasFactory;

    protected $fillable = [
        'names',
        'first_surname',
        'second_surname',
        'age',
        'gender',
        'address',
        'birthday',
        'specialty',
        'type',
        'professional_license',
        'phone',
        'curp',
        'sex'
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
}
