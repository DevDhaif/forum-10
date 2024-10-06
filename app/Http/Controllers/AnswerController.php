<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Point;
use App\Models\Question;
use App\Services\AchievementService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($channelId, Question $question)
    {
        $this->validate(
            request(),
            [
                'body' => 'required',
            ]
        );

        $answer = $question->addAnswer([
            'body' => request('body'),
            'user_id' => auth()->id(),
        ]);
        Point::create([
            'user_id' => $answer->user_id,
            'source' => 'answer',
            'source_id' => $answer->id,
            'points' => 3,
        ]);
        $question->update(['is_answered' => 1]);
        $question = $question->fresh();

        $achievementService = new AchievementService();
        $achievementService->checkForAchievements($answer->owner);

        $answers = $question->answers()->latest()->paginate(10)->withPath("/questions/{$question->channel->slug}/{$question->id}");
        if (request()->expectsJson()) {
            return response()->json([
                'answer' => $answer,
                'flash' => 'leftAnswer',
                'answers' => $answers,
                'question' => $question,
            ]);
        }
        session()->flash('message', 'Your answer has been left!');

        return redirect($question->path());;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update([
            'body' => request('body'),
        ]);
        if (request()->expectsJson()) {

            return response()->json([
                'answer' => $answer,
                'flash' => 'updatedAnswer',
            ]);
        }
        session()->flash('message', 'Your answer has been updated!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);
        $question = $answer->question;
        Point::where([
            'user_id' => $answer->user_id,
            'source' => 'answer',
            'source_id' => $answer->id,
        ])->delete();
        $answer->delete();
        $answers = $question->answers()->latest()->paginate(10)->withPath("/questions/{$question->channel->slug}/{$question->id}");
        if ($question->answers_count == 0) {
            $question->update(['is_answered' => 0]);
        }
        if (request()->expectsJson()) {
            return response()->json([
                'flash' => 'deletedAnswer',
                'answers' => $answers,
                'question' => $question,
            ]);
        }
        session()->flash('message', 'Your answer has been deleted!');
        return redirect()->back();
    }
    public function isUpvoted(Answer $answer)
    {
        $isUpvoted = $answer->isUpvotedByUser(auth()->user());

        return response()->json(['isUpvoted' => $isUpvoted]);
    }
    public function isDownvoted(Answer $answer)
    {
        $isDownvoted = $answer->isDownvotedByUser(auth()->user());

        return response()->json(['isDownvoted' => $isDownvoted]);
    }

    public function best(Question $question, Answer $answer)
    {
        $this->authorize('update', $question);
        Point::create([
            'user_id' => $answer->user_id,
            'source' => 'best',
            'source_id' => $answer->id,
            'points' => 10,
        ]);
        $question->markAsBest($answer);

        $achievementService = new AchievementService();
        $achievementService->checkForAchievements($answer->owner);

        if (request()->expectsJson()) {
            return response()->json([
                'flash' => 'bestAnswerMarked',
                'question' => $question,
            ]);
        }
        session()->flash('message', 'The best answer has been marked!');
        return back();
    }
    public function removeBest(Question $question, Answer $answer)
    {
        $this->authorize('update', $question);
        Point::where([
            'user_id' => $answer->user_id,
            'source' => 'best',
            'source_id' => $answer->id,
        ])->delete();
        $question->removeBestAnswer($answer);
        if (request()->expectsJson()) {
            return response()->json([
                'flash' => 'bestAnswerRemoved',
                'question' => $question,
            ]);
        }
        session()->flash('message', 'The best answer has been removed!');
        return back();
    }
}
