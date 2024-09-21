<?php

namespace App\Models;

use App\Favoritable;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    use Favoritable;
    use RecordsActivity;

    protected $guarded = [];

    protected $appends = ['favorites_count'];
    protected $with = ['owner', 'favorites', 'channel', 'thread'];
    protected static $favoritedReplyIds = [];
    public static function loadFavoritedReplyIdsForUser($user)
    {
        if ($user) {
            self::$favoritedReplyIds = Favorite::where('user_id', $user->id)
                ->where('favorited_type', self::class)
                ->pluck('favorited_id')
                ->all();
        }
    }

    protected static function boot()
    {

        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleting(function ($reply) {
            $reply->activity->each(function ($activity) {
                $activity->delete();
            });
            $reply->favorites->each(function ($favorite) {
                $favorite->delete();
            });
            $reply->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
    public function isFavoritedByUser($user)
    {
        if (!$user) {
            return false;
        }

        return $this->favorites->where('user_id', $user->id)->isNotEmpty();
    }
    public function getPathAttribute()
    {
        return $this->thread->path . "#reply-{$this->id}";
    }
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
