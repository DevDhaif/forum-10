<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);

        $result = $voteable->toggleUpvote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function downvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);

        $result = $voteable->toggleDownvote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function removeUpvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);
        $result = $voteable->toggleUpvote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function removeDownvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);
        $result = $voteable->toggleDownvote();
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
