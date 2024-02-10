<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if($favoritable->isFavorited()){
            $favoritable->unfavorite();
            return back();
        } else {

            $favoritable->favorite();
            return back();
        }
    }
    public function destroy($type, $id)

    {
        $favoritable = $this->getFavoritable($type, $id);
        $favoritable->favorites()->where('user_id', auth()->id())->get()->each->delete();
        return response()->json(null, 204);
    }

    protected function getFavoritable($type, $id)
    {
        $class = "App\\Models\\" . ucfirst($type);
        return $class::findOrFail($id);
    }
}
