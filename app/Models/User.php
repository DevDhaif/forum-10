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

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
    public function getPathAttribute()
    {
        return $this->path();
    }
    public function points(){
        return $this->hasMany(Point::class);
    }
}
