<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPersonalData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_personal_data';

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
