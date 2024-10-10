<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Question;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LeaderboardController extends Controller
{


    public function index(Request $request)
    {
        $range = $request->query('range', '7');

        switch ($range) {
            case '7':
                $startDate = Carbon::now()->subDays(7);
                break;
            case '14':
                $startDate = Carbon::now()->subDays(14);
                break;
            case '30':
                $startDate = Carbon::now()->subDays(30);
                break;
            case '60':
                $startDate = Carbon::now()->subDays(60);
                break;
            case '180':
                $startDate = Carbon::now()->subDays(180);
                break;
            case '365':
                $startDate = Carbon::now()->subDays(365);
                break;
            case 'all':
            default:
                $startDate = null;
                break;
        }

        $query = User::query()->withSum('points', 'points');

        if ($startDate) {
            $query->whereHas('points', function ($q) use ($startDate) {
                $q->where('created_at', '>=', $startDate);
            });
        }

        $topUsers = $query->orderBy('points_sum_points', 'desc')->take(10)->get();

        $topThreads = Thread::query()
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->withCount('replies')
            ->orderBy('replies_count', 'desc')
            ->take(10)
            ->get();

        $topQuestions = Question::query()
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->withCount('answers')
            ->orderBy('answers_count', 'desc')
            ->take(10)
            ->get();

        $topChannels = DB::table('channels')
            ->leftJoin(DB::raw('(SELECT channel_id, COUNT(*) as threads_count FROM threads WHERE created_at >= ? GROUP BY channel_id) as threads'), function ($join) use ($startDate) {
                $join->on('channels.id', '=', 'threads.channel_id')
                    ->addBinding([$startDate]);
            })
            ->leftJoin(DB::raw('(SELECT channel_id, COUNT(*) as questions_count FROM questions WHERE created_at >= ? GROUP BY channel_id) as questions'), function ($join) use ($startDate) {
                $join->on('channels.id', '=', 'questions.channel_id')
                    ->addBinding([$startDate]);
            })
            ->select('channels.id', 'channels.name', DB::raw('COALESCE(threads.threads_count, 0) + COALESCE(questions.questions_count, 0) as contributions'))
            ->groupBy('channels.id', 'channels.name')
            ->orderByDesc('contributions')
            ->take(10)
            ->get();

        return Inertia::render('Leaderboard/Index', [
            'topUsers' => $topUsers,
            'topThreads' => $topThreads,
            'topQuestions' => $topQuestions,
            'topChannels' => $topChannels,
        ]);
    }
}
