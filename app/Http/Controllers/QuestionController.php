<?php

namespace App\Http\Controllers;

use App\Filters\QuestionFilters;
use App\Http\Requests\CreateQuestionRequest;
use App\Models\Answer;
use App\Models\Channel;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

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
        // dd($questions);
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
        $channels = Cache::get('channels');
        $channel = $channels->firstWhere('slug', $channelSlug);

        // if (!$channel || $question->channel_id !== $channel->id) {
        //     abort(404);
        // }

        Answer::loadVotedAnswerIdsForUser(auth()->user());

        $answers = $question->answers()->latest()->paginate(10);

        foreach ($answers as $answer) {
            $answer->isVoted = $answer->isVotedByUser(auth()->user());
        }

        $user = auth()->user();
        if ($user && $user->roles->isNotEmpty()) {
            $user->role = $user->roles->first()->name;
        }

        return Inertia::render('Question/Show', [
            'question' => $question,
            'answers' => $answers,
            'user' => $user,
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
