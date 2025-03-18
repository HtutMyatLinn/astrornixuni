<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $primaryKey = 'contribution_id';
    protected $fillable = ['intake_id', 'contribution_category_id', 'user_id', 'contribution_cover', 'contribution_title', 'contribution_description', 'contribution_file_path', 'submitted_date', 'contribution_status', 'view_count'];
    protected $casts = [
        'submitted_date' => 'datetime',
        'published_date' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function category()
    {
        return $this->belongsTo(ContributionCategory::class, 'contribution_category_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'contribution_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'contribution_id');
    }

    public function images()
    {
        return $this->hasMany(ContributionImage::class, 'contribution_id');
    }
}
