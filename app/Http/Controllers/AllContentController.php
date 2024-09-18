<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Filters\ThreadFilters;
use App\Filters\QuestionFilters;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Inertia;

class AllContentController extends Controller
{
    public function index(Channel $channel, ThreadFilters $threadFilters, QuestionFilters $questionFilters, Request $request)
    {
        $threadsQuery = app(ThreadController::class)->getThreads($channel, $threadFilters);
        $questionsQuery = app(QuestionController::class)->getQuestions($channel, $questionFilters);

        // Apply the popularity filter only if ?popular=1 is present
        if ($request->has('popular')) {
            // Apply popularity sorting
            $threadsQuery = $threadsQuery->orderBy('replies_count', 'desc');
            $questionsQuery = $questionsQuery->orderBy('answers_count', 'desc');
        } else {
            // Default sorting by creation time
            $threadsQuery = $threadsQuery->orderBy('created_at', 'desc');
            $questionsQuery = $questionsQuery->orderBy('created_at', 'desc');
        }

        // Fetch the results (after sorting and filtering)
        $threads = $threadsQuery->get();
        $questions = $questionsQuery->get();

        // Add a virtual 'popularity_count' field only if we are sorting by popularity
        if ($request->has('popular')) {
            $threads = $threads->map(function ($thread) {
                $thread->popularity_count = $thread->replies_count;
                return $thread;
            });

            $questions = $questions->map(function ($question) {
                $question->popularity_count = $question->answers_count;
                return $question;
            });

            // Merge and sort by popularity_count
            $combined = $threads->merge($questions);
            $sorted = $combined->sortByDesc('popularity_count');
        } else {
            // Merge and sort by created_at
            $combined = $threads->merge($questions);
            $sorted = $combined->sortByDesc('created_at');
        }

        $perPage = 20;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginated = new LengthAwarePaginator(
            $sorted->slice(($page - 1) * $perPage, $perPage)->values(),
            $sorted->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return Inertia::render('All/Index', [
            'content' => $paginated,
            'channel' => $channel->exists ? $channel->slug : null,
        ]);
    }
}
