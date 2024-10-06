<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Point;
use App\Models\Question;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Str;

class LeaderboardController extends Controller
{


    public function index(Request $request)
    {
        $range = $request->query('range', '7'); // Default to 7 days

        // Determine the start date based on the range
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
                $startDate = null; // No date filter for "all"
                break;
        }

        // Build the query to get top users with points in the given range
        $query = User::query()->withSum('points', 'points');

        // If there is a start date, filter points based on the date range
        if ($startDate) {
            $query->whereHas('points', function ($q) use ($startDate) {
                $q->where('created_at', '>=', $startDate);
            });
        }

        // Get the top 10 users
        $topUsers = $query->orderBy('points_sum_points', 'desc')->take(10)->get();

        $topThreads = Thread::query()
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->withCount('replies') // Assuming replies count is a criteria for top threads
            ->orderBy('replies_count', 'desc') // Order by most replies
            ->take(10)
            ->get();

        $topQuestions = Question::query()
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('created_at', '>=', $startDate);
            })
            ->withCount('answers') // Assuming replies count is a criteria for top threads
            ->orderBy('answers_count', 'desc') // Order by most replies
            ->take(10)
            ->get();

        $topChannels = DB::table('channels')
            ->leftJoin('threads', 'channels.id', '=', 'threads.channel_id')
            ->leftJoin('questions', 'channels.id', '=', 'questions.channel_id')
            ->select('channels.id', 'channels.name', DB::raw('COUNT(threads.id) + COUNT(questions.id) as contributions'))
            ->when($startDate, function ($query) use ($startDate) {
                return $query->where('threads.created_at', '>=', $startDate)
                    ->orWhere('questions.created_at', '>=', $startDate);
            })
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





    // Methods to retrieve the top data for each category

    private function getTopFavoriteThreads($startDate)
    {
        $query = Thread::with('creator', 'channel')
            ->select('threads.id', 'threads.title', DB::raw('COUNT(favorites.id) as favorites_count'))
            ->join('favorites', 'favorites.favorited_id', '=', 'threads.id')
            ->groupBy('threads.id')
            ->orderBy('favorites_count', 'desc')
            ->limit(10);

        if ($startDate) {
            $query->where('favorites.created_at', '>=', $startDate);
        }

        return $query->get();
    }
    private function getTopUsersByPoints($startDate)
    {
        $query = User::select('users.id', 'users.name', DB::raw('SUM(points.points) as total_points'))
            ->join('points', 'points.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->orderBy('total_points', 'desc')
            ->limit(10);

        if ($startDate) {
            $query->where('points.created_at', '>=', $startDate);
        }

        return $query->get();
    }

    private function getTopUsersByAchievements($startDate)
    {
        $query = User::select('users.id', 'users.name', DB::raw('COUNT(user_achievements.achievement_id) as total_achievements'))
            ->join('user_achievements', 'user_achievements.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->orderBy('total_achievements', 'desc')
            ->limit(10);

        if ($startDate) {
            $query->where('user_achievements.created_at', '>=', $startDate);
        }

        return $query->get();
    }

    private function getTopThreadCreators($startDate)
    {
        $query = User::select('users.id', 'users.name', DB::raw('COUNT(threads.id) as total_threads'))
            ->join('threads', 'threads.user_id', '=', 'users.id')
            ->groupBy('users.id')
            ->orderBy('total_threads', 'desc')
            ->limit(10);

        if ($startDate) {
            $query->where('threads.created_at', '>=', $startDate);
        }

        return $query->get();
    }

    private function getTopUsersByProfileVisits($startDate)
    {
        $query = User::select('users.id', 'users.name', 'profile_visits')
            ->orderBy('profile_visits', 'desc')
            ->limit(10);

        return $query->get();
    }

    // public function index()
    // {
    //     // Top 10 users in the last 7 days
    //     $topUsersLast7Days = $this->getTopUsersByPeriod(7, 10);

    //     // Top 20 users in the last 30 days
    //     $topUsersLast30Days = $this->getTopUsersByPeriod(30, 20);

    //     // Top 40 users in the last 60 days
    //     $topUsersLast60Days = $this->getTopUsersByPeriod(60, 40);

    //     // Add more statistics if needed...
    //     $topThreadCreators = $this->getTopThreadCreators(7, 10);

    //     $topAnswerGivers = $this->getTopAnswerGivers(7, 10);


    //     $topFavoriteThreads = $this->getTopFavoriteThreads(300, 10);


    //     $topQuestionAskers = $this->getTopQuestionAskers(7, 10);

    //     return Inertia::render('Leaderboard/Index', [
    //         'topUsersLast7Days' => $topUsersLast7Days,
    //         'topThreadCreators' => $topThreadCreators,
    //         'topUsersLast30Days' => $topUsersLast30Days,
    //         'topUsersLast60Days' => $topUsersLast60Days,
    //         'topQuestionAskers' => $topQuestionAskers,
    //         'topAnswerGivers' => $topAnswerGivers,
    //         'topFavoriteThreads' => $topFavoriteThreads,

    //         // Add more statistics if needed...
    //     ]);
    // }


    // private function getTopUsersByPeriod($days, $limit)
    // {
    //     return User::select('users.id', 'users.name', 'users.email', DB::raw('SUM(points.points) as total_points'))
    //         ->join('points', 'points.user_id', '=', 'users.id')  // Join with points table
    //         ->where('points.created_at', '>=', Carbon::now()->subDays($days))  // Filter by date range
    //         ->groupBy('users.id')  // Group by user to get total points per user
    //         ->orderByRaw('SUM(points.points) DESC')  // Order by total points
    //         ->limit($limit)  // Limit the results
    //         ->get();  // Get the data with total_points
    // }
    // private function getTopThreadCreators($days, $limit)
    // {
    //     return User::select('users.id', 'users.name', 'users.email', DB::raw('COUNT(threads.id) as total_threads'))
    //         ->join('threads', 'threads.user_id', '=', 'users.id')
    //         ->where('threads.created_at', '>=', Carbon::now()->subDays($days))
    //         ->groupBy('users.id')
    //         ->orderBy('total_threads', 'desc')
    //         ->limit($limit)
    //         ->get();
    // }

    // private function getTopQuestionAskers($days, $limit)
    // {
    //     return User::select('users.id', 'users.name', 'users.email', DB::raw('COUNT(questions.id) as total_questions'))
    //         ->join('questions', 'questions.user_id', '=', 'users.id')
    //         ->where('questions.created_at', '>=', Carbon::now()->subDays($days))
    //         ->groupBy('users.id')
    //         ->orderBy('total_questions', 'desc')
    //         ->limit($limit)
    //         ->get();
    // }
    // private function getTopAnswerGivers($days, $limit)
    // {
    //     return User::select('users.id', 'users.name', 'users.email', DB::raw('COUNT(answers.id) as total_answers'))
    //         ->join('answers', 'answers.user_id', '=', 'users.id')
    //         ->where('answers.created_at', '>=', Carbon::now()->subDays($days))
    //         ->groupBy('users.id')
    //         ->orderBy('total_answers', 'desc')
    //         ->limit($limit)
    //         ->get();
    // }
    // // Get top favorite thread creators
    // private function getTopFavoriteThreads($days, $limit)
    // {
    //     return Thread::with(['creator', 'channel', 'favorites'])
    //         ->select('threads.id', 'threads.title', 'threads.user_id', 'threads.channel_id', DB::raw('COUNT(favorites.id) as favorites_count'))
    //         ->join('favorites', function ($join) {
    //             $join->on('threads.id', '=', 'favorites.favorited_id')
    //                 ->where('favorites.favorited_type', '=', Thread::class);
    //         })
    //         ->where('favorites.created_at', '>=', Carbon::now()->subDays($days))
    //         ->groupBy('threads.id', 'threads.channel_id', 'threads.title', 'threads.user_id')
    //         ->orderBy('favorites_count', 'desc')
    //         ->limit($limit)
    //         ->get();
    // }
}
