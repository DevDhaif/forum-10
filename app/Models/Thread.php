<?php

namespace App\Models;

use App\Favoritable;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    use Favoritable;
    use RecordsActivity;
    protected $guarded = [];
    protected $fillable = ['title', 'body', 'channel_id','user_id'];
    protected $appends = ['favorites_count', 'isFavorited', 'path'];
    protected $with = ['creator', 'channel', 'favorites'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each(function ($reply) {
                $reply->delete();
            });
            $thread->activity->each(function ($activity) {
                $activity->delete();
            });
            $thread->favorites->each(function ($favorite) {
                $favorite->delete();
            });
        });
    }

    public function path()
    {
        $slug = $this->channel ? $this->channel->slug : '';
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
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function getPathAttribute()
    {
        return $this->path();
    }
}
