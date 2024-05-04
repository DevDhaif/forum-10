<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);

        $result = $voteable->toggleVote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function destroy($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);
        $result = $voteable->toggleVote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    protected function getVoteable($type, $id)
    {
        $class = "App\\Models\\" . ucfirst($type);
        return $class::findOrFail($id);
    }
}
