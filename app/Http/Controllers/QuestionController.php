<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Answer;
use App\Models\Channel;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Filters\QuestionFilters;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\CreateQuestionRequest;

class QuestionController extends Controller
{
    public function __construct()
    {
    }
    public function getQuestions(Channel $channel, QuestionFilters $filters)
    {
        $questions = Question::latest()->filter($filters);
        if ($channel->exists) {
            $questions = $questions->where('channel_id', $channel->id);
        }
        // return json questions
        return $questions;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Channel $channel, QuestionFilters $filters, Request $request)
    {
        $questions = $this->getQuestions($channel, $filters)->latest()->paginate(50);
        $questions->appends($request->query());
        $questions->load('creator');
        return Inertia::render('Question/Index', [
            'questions' => $questions,
            'channel' => $channel->slug,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render(
            'Question/Create',
            [
                'user' => auth()->user(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateQuestionRequest $request)
    {
        try {

            $question = Question::create(
                array_merge(
                    $request->validated(),
                    ['user_id' => auth()->id()]
                )
            );

            session()->flash('success', 'Your question has been left!');

            return Inertia::location(route('questions.show', [$question->channel->slug, $question->id]));
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem creating your question');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($channelSlug, Question $question)
    {
        if (!session()->has("viewed_questions.{$question->id}")) {
            $question->increment('visits');
            session()->put("viewed_questions.{$question->id}", true);
        }
        // $channels = Cache::get('channels');
        // $channel = $channels->firstWhere('slug', $channelSlug);

        // if (!$channel || $question->channel_id !== $channel->id) {
        //     abort(404);
        // }

        Answer::loadVotedAnswerIdsForUser(auth()->user());

        $answers = $question->answers()->latest()->paginate(10);

        foreach ($answers as $answer) {
            $answer->isUpvoted = $answer->isUpvotedByUser(auth()->user());
            $answer->isDownvoted = $answer->isDownvotedByUser(auth()->user());
        }

        $user = auth()->user();
        if ($user && $user->roles->isNotEmpty()) {
            $user->role = $user->roles->first()->name;
        }
        $question->load('creator');
        return Inertia::render('Question/Show', [
            'question' => $question,
            'answers' => $answers,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel, Question $question)
    {
        if ($question->channel_id !== $channel->id) {
            abort(404);
        }
        $this->authorize('update', $question);
        return Inertia::render('Question/Edit', [
            'question' => $question,
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Channel $channel, Question $question)
    {
        DB::beginTransaction();

        try {
            if ($question->channel_id != $channel->id) {
                abort(404, 'Question not found');
            }
            $this->authorize('update', $question);

            $question->update($request->only('title', 'body', 'channel_id'));

            $newChannel = Channel::find($request->channel_id);

            session()->flash('success', 'Your question has been updated!');

            DB::commit();

            return Inertia::location(route('questions.show', [$newChannel->slug, $question->id]));
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'There was a problem updating your question');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($channel, Question $question)
    {
        $this->authorize('delete', $question);
        try {
            $question->delete();

            session()->flash('success', 'Your question has been deleted!');

            return Inertia::location(route('questions'));
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem deleting your question');
            return back();
        }
    }
}
