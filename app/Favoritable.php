<?php

namespace App;

use App\Models\Activity;
use App\Models\Favorite;

trait Favoritable
{

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
    public function toggleFavorite()
    {
        $userId = auth()->id();
        $favorite = $this->favorites()->where('user_id', $userId)->first();

        if ($favorite) {
            $favorite->delete();
            $isFavorited = false;
        } else {
            $this->favorites()->create(['user_id' => $userId]);
            $isFavorited = true;
        }

        $favorites_count = $this->favorites()->count();

        return [
            'isFavorited' => $isFavorited,
            'favorites_count' => $favorites_count,
        ];
    }

    public function getIsFavoritedAttribute()
    {
        return $this->favorites->where('user_id', auth()->id())->count() > 0;
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
