<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $fillable = [
        'user_code',
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'profile_image',
        'faculty_id',
        'role_id',
        'last_login_date',
        'last_password_changed_date',
        'password_expired_date',
        'login_count',
        'status'
    ];

    protected $casts = [
        'last_login_date' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'user_id');
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'user_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function passwordreset()
    {
        return $this->hasMany(PasswordResetRequest::class, 'request_id');
    }

    public function browserStats()
    {
        return $this->belongsToMany(BrowserStat::class, 'user_browser_stats', 'user_id', 'browser_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
