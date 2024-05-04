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
    public function toggleVote()
    {
        $userId = auth()->id();
        $vote = $this->votes()->where('user_id', $userId)->first();

        if ($vote) {
            $vote->delete();
            $isVoted = false;
        } else {
            $this->votes()->create(['user_id' => $userId]);
            $isVoted = true;
        }

        $votes_count = $this->votes()->count();

        return [
            'isVoted' => $isVoted,
            'votes_count' => $votes_count,
        ];
    }

    public function getIsVotedAttribute()
    {
        return $this->votes->where('user_id', auth()->id())->count() > 0;
    }
    public function getVotesCountAttribute()
    {
        return $this->votes->count();
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
