<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role'];

    // Define the relationship to the User model
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
