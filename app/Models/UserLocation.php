<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_locations';

    protected $fillable = [
        'latitude',
        'length',
        'zone'
    ];
}
