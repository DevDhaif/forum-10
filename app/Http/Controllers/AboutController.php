<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Channel;
use App\Models\Question;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalThreads = Thread::count();
        $totalQuestions = Question::count();
        $totalReplies = Reply::count();
        $totalAnswers = Answer::count();
        $totalChannels = Channel::count();
        $totalAiAnswers = Answer::where('by_ai', 1)->count();
        $questionsLastMonth = Question::where('created_at', '>=', now()->subMonth())->count();
        $threadsLastMonth = Thread::where('created_at', '>=', now()->subMonth())->count();

        return Inertia::render('AboutPage', [
            'totalUsers' => $totalUsers,
            'totalThreads' => $totalThreads,
            'totalQuestions' => $totalQuestions,
            'totalReplies' => $totalReplies,
            'totalAnswers' => $totalAnswers,
            'totalChannels' => $totalChannels,
            'totalAiAnswers' => $totalAiAnswers,
            'questionsLastMonth' => $questionsLastMonth,
            'threadsLastMonth' => $threadsLastMonth,
        ]);
    }
}
