<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
    protected $fillable = ['role', 'functionalities'];

    // Define the relationship to the User model
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
