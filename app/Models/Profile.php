<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['profile'];

    // Defining relationship to user.
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }
}
