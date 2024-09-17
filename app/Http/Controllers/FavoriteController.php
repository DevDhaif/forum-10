<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Point;
use App\Models\Reply;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store($type, $id)
    {
        $favoritable = $this->getFavoritable($type, $id);
        Point::create([
            'user_id' => $favoritable->user_id,
            'source' => 'favorite',
            'source_id' => $favoritable->id,
            'points' => 1,
        ]);
        $result = $favoritable->toggleFavorite();

        logger()->info('Favoritable:', ['favoritable' => $favoritable]);

        $favoritableUser = $this->getFavoritableUser($favoritable);
        logger()->info('Favoritable User:', ['user' => $favoritableUser]);

        // $favoritableUser = $this->getFavoritableUser($favoritable);

        if ($favoritableUser) {
            $achievementService = new AchievementService();
            $achievementService->checkForAchievements($favoritableUser);
        }

        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function destroy($type, $id)
    {
        $favoritable = $this->getFavoritable($type, $id);
        Point::where([
            'user_id' => $favoritable->user_id,
            'source' => 'favorite',
            'source_id' => $favoritable->id,
        ])->delete();
        $result = $favoritable->toggleFavorite();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }

    protected function getFavoritable($type, $id)
    {
        $class = "App\\Models\\" . ucfirst($type);
        return $class::findOrFail($id);
    }
    protected function getFavoritableUser($favoritable)
    {
        // Check if the favoritable has a `creator` method (Thread)
        if (method_exists($favoritable, 'creator')) {
            return $favoritable->creator;
        }

        // Check if the favoritable has an `owner` method (Reply)
        if (method_exists($favoritable, 'owner')) {
            return $favoritable->owner;
        }

        return null;
    }
}
