<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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
        $cacheKey = "user:{$user->id}:feed";
        return Cache::remember($cacheKey, 10, function () use ($user, $take) {

            return static::where('user_id', $user->id)
                ->latest()
                ->with(['subject' => function ($morphTo) {
                    $morphTo->morphWith([
                        // Thread::class => ['creator', 'channel'],
                        // Question::class => ['creator', 'channel'],
                        // Reply::class => ['owner', 'thread'],
                        // Answer::class => ['owner', 'question'],
                        Favorite::class => ['favorited'],
                        Vote::class => ['voted'],
                    ]);
                }])
                ->take($take)
                ->get()
                ->map(function ($activity) {

                    // if ($activity->subject) {
                    // if ($activity->subject_type === Reply::class || $activity->subject_type === Answer::class) {
                    //         $activity->subject->path = $activity->subject->path();
                    //     } elseif ($activity->subject_type === Favorite::class) {
                    //         if ($activity->subject->favorited_type === Reply::class) {
                    //             $activity->subject->favorited->path = $activity->subject->favorited->path();
                    //         } elseif ($activity->subject->favorited_type === Thread::class) {
                    //             $activity->subject->favorited->path = $activity->subject->favorited->path();
                    //         }
                    //     }
                    // }
                    return $activity;
                })
                ->groupBy(function ($activity) {
                    return $activity->created_at->format('Y-m-d');
                });
        });
    }
}
