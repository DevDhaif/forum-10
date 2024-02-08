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
    public function store(Reply $reply)
    {
        if($reply->isFavorited()) {
            $reply->unfavorite();
            return back();
        } else {

            $reply->favorite();
            return back();
        }
    }
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
        return response()->json(null, 204);
    }
}
