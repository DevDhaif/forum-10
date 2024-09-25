<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Achievement;
use App\Models\Activity;
use App\Models\Field;
use App\Models\University;
use App\Models\User;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(Request $request, User $user)
    {
        $user->increment('profile_visits');

        $achievementService = new AchievementService();
        $achievementService->checkForAchievements($user);

        $allAchievements = Achievement::all();
        $unlockedAchievements = $user->achievements;

        $universities = University::all();
        $fields = Field::all();
        $currentProgress = [
            'threads' => $user->threads()->count(),
            'questions' => $user->questions()->count(),
            'replies_count' => $user->threads()->sum('replies_count'),
            'answers_count' => $user->answers()->count(),
            'favorites' => $user->favorites()->count(),
            'votes' => $user->votes()->count(),
            'visits' => $user->threads()->sum('visits') + $user->questions()->sum('visits'),
            'profile_visits' => $user->profile_visits,
            'points' => $user->points()->sum('points'),
            'streak' => $user->streak_days,
            'milestone' => $user->achievements()->count(),
        ];
        $user->load([
            'university' => function ($query) {
                $query->select('name', 'id');
            },
            'field' => function ($query) {
                $query->select('name', 'id');
            },
            'roles',
            'threads.creator',
            'points',
            'questions',
            'answers',
            'replies',
            'votes.voted',
            'favorites.favorited',

        ]);
        $points = $user->points()->sum('points');
        return Inertia::render('Profile/Index', [
            'profileUser' => $user,
            'threads' => $user->threads,
            'questions' => $user->questions,
            'answers' => $user->answers,
            'replies' => $user->replies,
            'votes' => $user->votes,
            'favorites' => $user->favorites,
            'activities' => Activity::feed($user, 50),
            'points' => $points,
            'allAchievements' => $allAchievements,
            'unlockedAchievements' => $unlockedAchievements,
            'currentProgress' => $currentProgress,
            'universities' => $universities,
            'fields' => $fields,
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, User $user)
    {
        if (!$request->user()->hasRole('admin') && $request->user()->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        $user->load('university', 'field', 'roles');

        return response()->json($user, 200);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(User $user, Request $request)
    {
        if ($user->id !== $request->user()->id && !$request->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized User'], 403);
        }
        if (!$request->user()->hasRole('admin')) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current-password'],
            ]);
        }
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'User deleted'], 200);
    }
}
