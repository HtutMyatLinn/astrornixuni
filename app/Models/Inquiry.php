<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $primaryKey = 'inquiry_id';
    protected $fillable = ['user_id', 'inquiry', 'priority_level', 'inquiry_status', 'inquiry_date', 'response_date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
