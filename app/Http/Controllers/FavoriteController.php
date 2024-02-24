<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
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
        Log::info('Storing favorite');
        $favoritable = $this->getFavoritable($type, $id);

        $result = $favoritable->toggleFavorite();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();

    }
    public function destroy($type, $id)
    {
        $favoritable = $this->getFavoritable($type, $id);
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
