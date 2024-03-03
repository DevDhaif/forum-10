<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $with = ['subject'];

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($activity) {
            $activity->subject->delete();
        });
    }
    public function subject()
    {
        return $this->morphTo();
    }


    static protected function feed($user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
