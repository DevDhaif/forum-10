<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Point;
use App\Models\Reply;
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
}
