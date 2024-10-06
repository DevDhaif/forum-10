<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'university_id',
        'field_id',
        'streak_days',
        'last_login'
    ];

    protected $appends = ['path'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function path()
    {
        return "/profiles/{$this->name}";
    }
    public function university()
    {
        return $this->belongsTo(University::class);
    }
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
    public function getPathAttribute()
    {
        return $this->path();
    }
    public function points()
    {
        return $this->hasMany(Point::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')->withTimestamps();
    }
    public function getLevelAttribute()
    {
        $points = $this->points()->sum('points');

        if ($points >= 1000) {
            return 'Legend';
        } elseif ($points >= 900) {
            return 'Grandmaster';
        } elseif ($points >= 800) {
            return 'Master';
        } elseif ($points >= 700) {
            return 'Expert';
        } elseif ($points >= 600) {
            return 'Advanced';
        } elseif ($points >= 500) {
            return 'Proficient';
        } elseif ($points >= 400) {
            return 'Intermediate';
        } elseif ($points >= 350) {
            return 'Apprentice';
        } elseif ($points >= 300) {
            return 'Novice';
        } else {
            return 'Beginner';  // For users with less than 300 points
        }
    }
}
