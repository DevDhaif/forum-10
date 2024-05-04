<?php

namespace App\Models;

use App\Voteable;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    use Voteable;
    use RecordsActivity;
    protected $guarded = [];
    protected $appends = ['votes_count', 'isVoted', 'path', 'is_answered'];
    protected $with = ['creator', 'channel', 'votes'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            $question->answers->each(function ($answer) {
                $answer->delete();
            });
            $question->activity->each(function ($activity) {
                $activity->delete();
            });
            $question->votes->each(function ($vote) {
                $vote->delete();
            });
        });
    }

    public function path()
    {
        $slug = $this->channel ? $this->channel->slug  : ' ';
        return "/questions/{$slug}/{$this->id}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->withCount('votes')->with(['owner', 'votes', 'channel']);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addAnswer($answer)
    {
        return $this->answers()->create($answer);
    }

    public function isVoted()
    {
        return $this->votes()->where('user_id', auth()->id())->exists();
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, 'voted');
    }

    // public function getVotesCountAttribute()
    // {
    //     return $this->votes()->sum('vote');
    // }

    public function getIsVotedAttribute()
    {
        return $this->isVoted();
    }

    public function getIsAnsweredAttribute()
    {
        return $this->answers()->where('is_best', true)->exists();
    }

    public function markBestAnswer(Answer $answer)
    {
        $this->answers()->update(['is_best' => false]);
        $answer->update(['is_best' => true]);
        $this->is_answered = true;
        $this->save();
    }
    public function vote($vote)
    {
        $this->votes()->create($vote);
    }

    public function unvote()
    {
        $this->votes()->where('user_id', auth()->id())->delete();
    }

    public function getPathAttribute()
    {
        return $this->path();
    }
}
