<?php

namespace App;

use App\Models\Activity;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        Log::info('User ID: ' . $attributes['user_id']);

        if (! $this->favorites()->where($attributes)->exists()) {
            Log::info('Favoriting item');
            return $this->favorites()->create($attributes);
        }
        else{
            Log::info('Unfavoriting item');
            $this->favorites()->where($attributes)->get()->each->delete();
        }
    }
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id', auth()->id())->count();
    }
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
