<?php

namespace App\Models;

use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    use RecordsActivity;
    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();
        // order by replies_count desc

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each(function ($reply) {
                $reply->delete();
            });
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->withCount('favorites')->with(['owner', 'favorites' , 'channel']);

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
        $this->replies()->create($reply);
    }
    public function favorited()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function favorite()
    {
        $this->favorites()->create(['user_id' => auth()->id()]);
    }
    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }
    public function unfavorite()
    {
        $this->favorites()->where('user_id', auth()->id())->delete();
    }
}
