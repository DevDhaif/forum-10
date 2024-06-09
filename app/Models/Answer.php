<?php

namespace App\Models;

use App\Voteable;
use App\RecordsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    use Voteable;
    use RecordsActivity;

    protected $guarded = [];

    protected $appends = ['votes_count', 'is_best'];
    protected $with = ['owner', 'votes', 'question'];
    protected static $votedAnswerIds = [];
    public static function loadVotedAnswerIdsForUser($user)
    {
        if ($user) {
            self::$votedAnswerIds = Vote::where('user_id', $user->id)
                ->where('voted_type', self::class)
                ->pluck('voted_id')
                ->all();
        }
    }

    protected static function boot()
    {

        parent::boot();

        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleting(function ($answer) {
            $answer->activity->each(function ($activity) {
                $activity->delete();
            });
            $answer->votes->each(function ($vote) {
                $vote->delete();
            });
            if ($answer->question->answers_count > 0) {

                $answer->question->decrement('answers_count');
            }
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function path()
    {
        return $this->question->path() . "#answer-{$this->id}";
    }
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
    public function isUpvotedByUser($user)
    {
        if (!$user) {
            return false;
        }

        return $this->votes->where('user_id', $user->id)->where('type', 'upvote')->isNotEmpty();
    }

    public function isDownvotedByUser($user)
    {
        if (!$user) {
            return false;
        }

        return $this->votes->where('user_id', $user->id)->where('type', 'downvote')->isNotEmpty();
    }
    public function getPathAttribute()
    {
        return $this->question->path . "#answer-{$this->id}";
    }
    public function getIsBestAttribute()
    {
        return $this->id === $this->question->best_answer_id;
    }
}
