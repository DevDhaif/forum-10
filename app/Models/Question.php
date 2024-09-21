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
    protected $appends = ['votes_count', 'isUpvoted', 'isDownvoted', 'path'];
    protected $with = ['creator', 'channel', 'votes'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($question) {
            $question->answers->each(function ($answer) {
                Point::where([
                    'user_id' => $answer->user_id,
                    'source' => 'answer',
                    'source_id' => $answer->id,
                ])->delete();
                $answer->delete();
            });
            $question->activity->each(function ($activity) {
                $activity->delete();
            });
            $question->votes->each(function ($vote) {
                Point::where([
                    'user_id' => $vote->user_id,
                    'source' => 'vote',
                    'source_id' => $vote->id,
                ])->delete();
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


    public function isUpvoted()
    {
        return $this->votes()->where('user_id', auth()->id())->where('type', 'upvote')->exists();
    }
    public function isDownvoted()
    {
        return $this->votes()->where('user_id', auth()->id())->where('type', 'downvote')->exists();
    }
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voted');
    }
    public function getIsUpvotedAttribute()
    {
        return $this->votes->contains(function ($vote) {
            return $vote->user_id == auth()->id() && $vote->type == 'upvote';
        });
    }
    public function getIsDownvotedAttribute()
    {
        return $this->votes->contains(function ($vote) {
            return $vote->user_id == auth()->id() && $vote->type == 'downvote';
        });
    }

    public function markAsBest(Answer $answer)
    {
        $this->answers()->update(['is_best' => false]);
        $answer->update(['is_best' => true]);
        $this->is_solved = true;
        $this->best_answer_id = $answer->id;
        $this->save();
    }
    public function removeBestAnswer(Answer $answer)
    {
        $this->answers()->update(['is_best' => false]);
        $this->is_solved = false;
        $this->best_answer_id = null;
        $this->save();
    }
    public function getPathAttribute()
    {
        return $this->path();
    }
    public function upvotes()
    {
        return $this->votes()->where('type', 'upvote');
    }

    public function downvotes()
    {
        return $this->votes()->where('type', 'downvote');
    }
}
