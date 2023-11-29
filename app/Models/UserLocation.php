<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_locations';

    protected $fillable = [
        'latitude',
        'length',
        'zone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
