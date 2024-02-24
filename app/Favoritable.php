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
    public function toggleFavorite()
    {
        $userId = auth()->id();
        $alreadyFavorited = $this->favorites()->where('user_id', $userId)->exists();

        if ($alreadyFavorited) {
            $favorite = $this->favorites()->where('user_id', $userId)->first();
            $isFavorited = false;
            if ($favorite) {
                $favorite->delete();
            }
        } else {
            $this->favorites()->create(['user_id' => $userId]);
            $isFavorited = true;
        }

        // Update favorites count (if not using separate column)
        $favorites_count = $this->favorites()->count();

        return [
            'isFavorited' => $isFavorited,
            'favorites_count' => $favorites_count,
        ];
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
