<?php

namespace App;

use App\Models\Activity;
use App\Models\Vote;

trait Voteable
{

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voted');
    }
    public function toggleUpvote()
    {
        $userId = auth()->id();
        $vote = $this->votes()->where('user_id', $userId)->first();

        if ($vote && $vote->type == 'upvote') {
            $vote->delete();
            $isUpvoted = false;
        } else {
            if ($vote) $vote->delete();
            $this->votes()->create(['user_id' => $userId, 'type' => 'upvote']);
            $isUpvoted = true;
        }

        $votes_count = $this->votes()->where('type', 'upvote')->count() - $this->votes()->where('type', 'downvote')->count();

        return [
            'isUpvoted' => $isUpvoted,
            'votes_count' => $votes_count,
        ];
    }
    public function toggleDownvote()
    {
        $userId = auth()->id();
        $vote = $this->votes()->where('user_id', $userId)->first();

        if ($vote && $vote->type == 'downvote') {
            $vote->delete();
            $isDownvoted = false;
        } else {
            if ($vote) $vote->delete();
            $this->votes()->create(['user_id' => $userId, 'type' => 'downvote']);
            $isDownvoted = true;
        }

        $votes_count = $this->votes()->where('type', 'upvote')->count() - $this->votes()->where('type', 'downvote')->count();

        return [
            'isDownvoted' => $isDownvoted,
            'votes_count' => $votes_count,
        ];
    }

    public function getIsUpvotedAttribute()
    {
        return $this->votes->where('user_id', auth()->id())->where('type', 'upvote')->count() > 0;
    }

    public function getIsDownvotedAttribute()
    {
        return $this->votes->where('user_id', auth()->id())->where('type', 'downvote')->count() > 0;
    }
    public function getVotesCountAttribute()
    {
        return $this->votes->where('type', 'upvote')->count() - $this->votes->where('type', 'downvote')->count();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
