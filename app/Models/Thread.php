<?php

namespace App\Models;

use App\Favoritable;
use App\RecordsActivity;
use App\Services\AchievementService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    use Favoritable;
    use RecordsActivity;
    protected $guarded = [];
    protected $appends = ['favorites_count', 'isFavorited', 'path'];
    protected $with = ['creator', 'channel', 'favorites'];

    protected static function boot()
    {
        parent::boot();

        // When a thread is created, check for achievements
        static::created(function ($thread) {
            $achievementService = new AchievementService();
            $achievementService->checkForAchievements($thread->creator);
        });
        static::deleting(function ($thread) {
            $thread->replies->each(function ($reply) {
                Point::where([
                    'user_id' => $reply->user_id,
                    'source' => 'reply',
                    'source_id' => $reply->id,
                ])->delete();
                $reply->delete();
            });
            $thread->activity->each(function ($activity) {
                $activity->delete();
            });
            $thread->favorites->each(function ($favorite) {
                Point::where([
                    'user_id' => $favorite->user_id,
                    'source' => 'favorite',
                    'source_id' => $favorite->id,
                ])->delete();
                $favorite->delete();
            });
        });
    }

    public function path()
    {
        $slug = $this->channel ? $this->channel->slug  : ' ';
        return "/threads/{$slug}/{$this->id}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->withCount('favorites')->with(['owner', 'favorites', 'channel']);
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }
    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->isNotEmpty();
    }
    // public function favorites()
    // {
    //     return $this->morphMany(Favorite::class, 'favorited');
    // }`
    public function getPathAttribute()
    {
        $slug = $this->channel ? $this->channel->slug  : ' ';
        return "/threads/{$slug}/{$this->id}";
    }
}
