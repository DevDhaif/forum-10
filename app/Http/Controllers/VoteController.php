<?php

namespace App\Http\Controllers;

use App\Models\Point;
use App\Services\AchievementService;
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

        $points = $type === 'question' ? 4 : 2;
        Point::create([
            'user_id' => $voteable->user_id,
            'source' => 'upvote',
            'source_id' => $voteable->id,
            'points' => $points,
        ]);
        $achievementService = new AchievementService();
        $achievementService->checkForAchievements($voteable->user);
        $result = $voteable->toggleUpvote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function downvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);

        $points = $type === 'question' ? -4 : -2;
        Point::create([
            'user_id' => $voteable->user_id,
            'source' => 'downvote',
            'source_id' => $voteable->id,
            'points' => $points,
        ]);

        $achievementService = new AchievementService();
        $achievementService->checkForAchievements($voteable->user);

        $result = $voteable->toggleDownvote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function removeUpvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);
        Point::where([
            'user_id' => $voteable->user_id,
            'source' => 'upvote',
            'source_id' => $voteable->id,
        ])->delete();
        $result = $voteable->toggleUpvote();
        if (request()->expectsJson()) {
            return response()->json($result);
        }
        return back();
    }
    public function removeDownvote($type, $id)
    {
        $voteable = $this->getVoteable($type, $id);
        Point::where([
            'user_id' => $voteable->user_id,
            'source' => 'upvote',
            'source_id' => $voteable->id,
        ])->delete();
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
