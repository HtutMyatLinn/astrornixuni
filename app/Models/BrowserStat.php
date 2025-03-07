<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrowserStat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'browser_id'; // Specify the primary key column
    protected $fillable = [
        'browser_name', // Add 'browser' to allow mass assignment
        'visit_count',   // Add 'count' to allow mass assignment
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_browser_stats', 'browser_id', 'user_id');
    }
}
