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
use App\Models\Point;
use App\Services\AchievementService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    public function __construct() {}
    public function getQuestions(Channel $channel, QuestionFilters $filters)
    {
        $questions = Question::latest()->filter($filters);
        if ($channel->exists) {
            $questions = $questions->where('channel_id', $channel->id);
        }
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
            'flash' => [
                'success' => session('success'),
                'error' => session('error')
            ],
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
            $response = Http::withHeaders([
                'content-type' => 'application/json',
                'x-api-key' => env('ANTHROPIC_API_KEY'),
                'anthropic-version' => '2023-06-01'
            ])->post('https://api.anthropic.com/v1/messages', [
                'model' => 'claude-3-5-sonnet-20240620',
                'max_tokens' => 1024,
                'messages' => [
                    ['role' => 'user', 'content' => 'You are a mentor and a senior developer. You are helping a junior developer with their questions and providing guidance, you should be able to answer this question based on the language and the context the question is asked, here is the question: ' . $question->body . 'do not ask for more information, answer the question based on the context and the language used, and do not introduce yourself or ask for more information or make an interoduction saying you are a mentor or a senior developer or you are happy to help, just answer the question.']
                ]
            ]);

            if ($response->successful()) {
                Log::info('Anthropic API Response:', $response->json());
                $generatedAnswer = $response->json()['content'][0]['text'];

                Answer::create([
                    'question_id' => $question->id,
                    'user_id' => auth()->id(),
                    'body' => $generatedAnswer,
                    'by_ai' => true,
                ]);
            } else {
                Log::error('Anthropic API Request Failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
            Point::create([
                'user_id' => $question->user_id,
                'source' => 'question',
                'source_id' => $question->id,
                'points' => 5,
            ]);
            $achievementService = new AchievementService();
            $achievementService->checkForAchievements($question->creator);

            session()->flash('success', 'questionLeft');
            return redirect()->route('questions.show', [$question->channel->slug, $question->id]);
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
            if ($question->visits % 100 == 0) {
                Point::create([
                    'user_id' => $question->user_id,
                    'source' => 'visits',
                    'source_id' => $question->id,
                    'points' => 10,
                ]);
                $achievementService = new AchievementService();
                $achievementService->checkForAchievements($question->creator);
            }
            session()->put("viewed_questions.{$question->id}", true);
        }
        // $channels = Cache::get('channels');
        // $channel = $channels->firstWhere('slug', $channelSlug);

        // if (!$channel || $question->channel_id !== $channel->id) {
        //     abort(404);
        // }
        $relatedQuestions = Question::where('channel_id', $question->channel->id)->latest()->take(10)->get();

        Answer::loadVotedAnswerIdsForUser(auth()->user());

        $answers = $question->answers()->orderByRaw('is_best DESC')->orderBy('by_ai', 'desc')->latest()->paginate(10);

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
            'relatedQuestions' => $relatedQuestions,
            'flashMessage' => session('success'),
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

            session()->flash('success', 'questionUpdated');

            DB::commit();
            return redirect()->route('questions.show', [$newChannel->slug, $question->id]);
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
            Point::where([
                'user_id' => $question->user_id,
                'source' => 'question',
                'source_id' => $question->id,
            ])->delete();
            $question->delete();

            session()->flash('success', 'questionDeleted');

            return redirect()->route('questions', $channel);
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem deleting your question');
            return back();
        }
    }
}
