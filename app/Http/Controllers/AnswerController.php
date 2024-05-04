<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
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

        $question = $question->fresh();

        $answers = $question->answers()->latest()->paginate(10)->withPath("/questions/{$question->channel->slug}/{$question->id}");
        if (request()->expectsJson()) {
            return response()->json([
                'answer' => $answer,
                'flash' => 'Your answer has been left!',
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
                'flash' => 'Your answer has been updated!'
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
        $answer->delete();
        $answers = $question->answers()->latest()->paginate(10)->withPath("/questions/{$question->channel->slug}/{$question->id}");

        if (request()->expectsJson()) {
            return response()->json([
                'flash' => 'Your answer has been deleted!',
                'answers' => $answers,
                'question' => $question,
            ]);
        }
        session()->flash('message', 'Your answer has been deleted!');
        return redirect()->back();
    }
    public function isVoted(Answer $answer)
    {
        $isVoted = $answer->isVotedByUser(auth()->user());

        return response()->json(['isVoted' => $isVoted]);
    }
}
