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

        static::addGlobalScope('replyCount' , function ($builder){
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
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
}
