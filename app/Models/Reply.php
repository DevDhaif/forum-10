<?php

namespace App\Models;

use App\Favoritable;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Reply extends Model
{
    use HasFactory;
    use Favoritable;
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected static function boot()
    {

        parent::boot();

        static::deleting(function ($reply){
            $reply->activity->each(function ($activity){
                $activity->delete();
            });
            $reply->favorites->each(function ($favorite){
                $favorite->delete();
            });
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
        // chech if there is no logged in user
        if (!$user) {
            return false;
        }
        return $this->favorites()->where('user_id', $user->id)->exists();
    }

}
