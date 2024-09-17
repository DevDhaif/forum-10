<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AchievementService
{
    public function checkForAchievements(User $user)
    {
        // Check thread-related achievements
        $threadCount = $user->threads()->count();
        $this->checkAchievement($user, 'threads', $threadCount);

        // Check question-related achievements
        $questionCount = $user->questions()->count();
        $this->checkAchievement($user, 'questions', $questionCount);

        // Check replies-related achievements
        $repliesCount = $user->threads()->sum('replies_count');
        $this->checkAchievement($user, 'replies_count', $repliesCount);

        // Check answers-related achievements
        $answerCount = $user->answers()->count();
        $this->checkAchievement($user, 'answers_count', $answerCount);

        // Check favorites-related achievements
        $favoritesCount = $user->favorites()->count(); // Count user's favorites
        $this->checkAchievement($user, 'favorites', $favoritesCount);

        // Check upvotes-related achievements
        $upvotesCount = $user->votes()->where('type', 'upvote')->count(); // Assuming a 'type' column
        $this->checkAchievement($user, 'votes', $upvotesCount);

        // Check visits-related achievements (threads and questions)
        $threadVisits = $user->threads()->sum('visits');
        $questionVisits = $user->questions()->sum('visits');
        $totalVisits = $threadVisits + $questionVisits;
        $this->checkAchievement($user, 'visits', $totalVisits);

        // Check profile visits achievements
        $profileVisits = $user->profile_visits;
        $this->checkAchievement($user, 'profile_visits', $profileVisits);

        // Check points-related achievements
        $points = $user->points()->sum('points');
        $this->checkAchievement($user, 'points', $points);

        // Check login streak achievements
        $streak = $this->calculateLoginStreak($user);
        $this->checkAchievement($user, 'streak', $streak);

        // Check total achievements unlocked
        $achievementCount = $user->achievements()->count();
        $this->checkAchievement($user, 'milestone', $achievementCount);

        // Logging for debugging
        Log::info('Checking achievements for user: ' . $user->id);
        Log::info('User has ' . $favoritesCount . ' favorites');
    }
    private function calculateLoginStreak(User $user)
    {
        // Assume 'last_login' is updated in User model
        $today = Carbon::today();
        $lastLogin = Carbon::parse($user->last_login);

        if ($lastLogin->isToday()) {
            // If user logged in today, continue the streak
            return $user->streak_days;
        } elseif ($lastLogin->diffInDays($today) == 1) {
            // User logged in yesterday, increase the streak
            $user->increment('streak_days');
            return $user->streak_days;
        } else {
            // Streak is broken, reset
            $user->streak_days = 1;
            $user->save();
            return $user->streak_days;
        }
    }
    protected function checkAchievement(User $user, $type, $currentValue)
    {
        // Find the achievements for the specified type
        $achievements = Achievement::where('type', $type)->get();

        foreach ($achievements as $achievement) {
            if ($currentValue >= $achievement->target && !$user->achievements->contains($achievement->id)) {
                $user->achievements()->attach($achievement->id);
            }
        }
    }
}
