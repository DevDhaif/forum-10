<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Thread Achievements
        Achievement::create(['name' => 'First Thread', 'type' => 'threads', 'target' => 1, 'level' => 'Beginner', 'description' => 'Post your first thread']);
        Achievement::create(['name' => '5 Threads', 'type' => 'threads', 'target' => 5, 'level' => 'Intermediate', 'description' => 'Post 5 threads']);
        Achievement::create(['name' => '10 Threads', 'type' => 'threads', 'target' => 10, 'level' => 'Advanced', 'description' => 'Post 10 threads']);
        Achievement::create(['name' => '25 Threads', 'type' => 'threads', 'target' => 25, 'level' => 'Expert', 'description' => 'Post 25 threads']);
        Achievement::create(['name' => '50 Threads', 'type' => 'threads', 'target' => 50, 'level' => 'Master', 'description' => 'Post 50 threads']);
        Achievement::create(['name' => '100 Threads', 'type' => 'threads', 'target' => 100, 'level' => 'Grandmaster', 'description' => 'Post 100 threads']);

        // Question Achievements
        Achievement::create(['name' => 'First Question', 'type' => 'questions', 'target' => 1, 'level' => 'Beginner', 'description' => 'Post your first question']);
        Achievement::create(['name' => '5 Questions', 'type' => 'questions', 'target' => 5, 'level' => 'Intermediate', 'description' => 'Post 5 questions']);
        Achievement::create(['name' => '10 Questions', 'type' => 'questions', 'target' => 10, 'level' => 'Advanced', 'description' => 'Post 10 questions']);
        Achievement::create(['name' => '25 Questions', 'type' => 'questions', 'target' => 25, 'level' => 'Expert', 'description' => 'Post 25 questions']);
        Achievement::create(['name' => '50 Questions', 'type' => 'questions', 'target' => 50, 'level' => 'Master', 'description' => 'Post 50 questions']);
        Achievement::create(['name' => '100 Questions', 'type' => 'questions', 'target' => 100, 'level' => 'Grandmaster', 'description' => 'Post 100 questions']);

        // Reply Achievements
        Achievement::create(['name' => 'First Reply', 'type' => 'replies_count', 'target' => 1, 'level' => 'Beginner', 'description' => 'Receive your first reply']);
        Achievement::create(['name' => '5 Replies', 'type' => 'replies_count', 'target' => 5, 'level' => 'Intermediate', 'description' => 'Receive 5 replies']);
        Achievement::create(['name' => '10 Replies', 'type' => 'replies_count', 'target' => 10, 'level' => 'Advanced', 'description' => 'Receive 10 replies']);
        Achievement::create(['name' => '25 Replies', 'type' => 'replies_count', 'target' => 25, 'level' => 'Expert', 'description' => 'Receive 25 replies']);
        Achievement::create(['name' => '50 Replies', 'type' => 'replies_count', 'target' => 50, 'level' => 'Master', 'description' => 'Receive 50 replies']);
        Achievement::create(['name' => '100 Replies', 'type' => 'replies_count', 'target' => 100, 'level' => 'Grandmaster', 'description' => 'Receive 100 replies']);

        // Answer Achievements
        Achievement::create(['name' => 'First Answer', 'type' => 'answers_count', 'target' => 1, 'level' => 'Beginner', 'description' => 'Receive your first answer']);
        Achievement::create(['name' => '5 Answers', 'type' => 'answers_count', 'target' => 5, 'level' => 'Intermediate', 'description' => 'Receive 5 answers']);
        Achievement::create(['name' => '10 Answers', 'type' => 'answers_count', 'target' => 10, 'level' => 'Advanced', 'description' => 'Receive 10 answers']);
        Achievement::create(['name' => '25 Answers', 'type' => 'answers_count', 'target' => 25, 'level' => 'Expert', 'description' => 'Receive 25 answers']);
        Achievement::create(['name' => '50 Answers', 'type' => 'answers_count', 'target' => 50, 'level' => 'Master', 'description' => 'Receive 50 answers']);
        Achievement::create(['name' => '100 Answers', 'type' => 'answers_count', 'target' => 100, 'level' => 'Grandmaster', 'description' => 'Receive 100 answers']);

        // Favorites Achievements
        Achievement::create(['name' => 'First Favorite', 'type' => 'favorites', 'target' => 1, 'level' => 'Beginner', 'description' => 'Receive your first favorite']);
        Achievement::create(['name' => '5 Favorites', 'type' => 'favorites', 'target' => 5, 'level' => 'Intermediate', 'description' => 'Receive 5 favorites']);
        Achievement::create(['name' => '10 Favorites', 'type' => 'favorites', 'target' => 10, 'level' => 'Advanced', 'description' => 'Receive 10 favorites']);
        Achievement::create(['name' => '25 Favorites', 'type' => 'favorites', 'target' => 25, 'level' => 'Expert', 'description' => 'Receive 25 favorites']);
        Achievement::create(['name' => '50 Favorites', 'type' => 'favorites', 'target' => 50, 'level' => 'Master', 'description' => 'Receive 50 favorites']);
        Achievement::create(['name' => '100 Favorites', 'type' => 'favorites', 'target' => 100, 'level' => 'Grandmaster', 'description' => 'Receive 100 favorites']);

        // Vote Achievements
        Achievement::create(['name' => 'First Vote', 'type' => 'votes', 'target' => 1, 'level' => 'Beginner', 'description' => 'Receive your first vote']);
        Achievement::create(['name' => '5 Votes', 'type' => 'votes', 'target' => 5, 'level' => 'Intermediate', 'description' => 'Receive 5 votes']);
        Achievement::create(['name' => '10 Votes', 'type' => 'votes', 'target' => 10, 'level' => 'Advanced', 'description' => 'Receive 10 votes']);
        Achievement::create(['name' => '25 Votes', 'type' => 'votes', 'target' => 25, 'level' => 'Expert', 'description' => 'Receive 25 votes']);
        Achievement::create(['name' => '50 Votes', 'type' => 'votes', 'target' => 50, 'level' => 'Master', 'description' => 'Receive 50 votes']);
        Achievement::create(['name' => '100 Votes', 'type' => 'votes', 'target' => 100, 'level' => 'Grandmaster', 'description' => 'Receive 100 votes']);

        // Visits Achievements
        Achievement::create(['name' => '5 Visits', 'type' => 'visits', 'target' => 5, 'level' => 'Beginner', 'description' => 'Get 5 visits to your threads or questions']);
        Achievement::create(['name' => '10 Visits', 'type' => 'visits', 'target' => 10, 'level' => 'Intermediate', 'description' => 'Get 10 visits to your threads or questions']);
        Achievement::create(['name' => '50 Visits', 'type' => 'visits', 'target' => 50, 'level' => 'Advanced', 'description' => 'Get 50 visits to your threads or questions']);
        Achievement::create(['name' => '100 Visits', 'type' => 'visits', 'target' => 100, 'level' => 'Expert', 'description' => 'Get 100 visits to your threads or questions']);
        Achievement::create(['name' => '200 Visits', 'type' => 'visits', 'target' => 200, 'level' => 'Master', 'description' => 'Get 200 visits to your threads or questions']);
        Achievement::create(['name' => '500 Visits', 'type' => 'visits', 'target' => 500, 'level' => 'Grandmaster', 'description' => 'Get 500 visits to your threads or questions']);

        // Profile Visit Achievements
        Achievement::create(['name' => '5 Profile Visits', 'type' => 'profile_visits', 'target' => 5, 'level' => 'Beginner', 'description' => 'Get 5 visits to your profile']);
        Achievement::create(['name' => '10 Profile Visits', 'type' => 'profile_visits', 'target' => 10, 'level' => 'Intermediate', 'description' => 'Get 10 visits to your profile']);
        Achievement::create(['name' => '25 Profile Visits', 'type' => 'profile_visits', 'target' => 25, 'level' => 'Advanced', 'description' => 'Get 25 visits to your profile']);
        Achievement::create(['name' => '50 Profile Visits', 'type' => 'profile_visits', 'target' => 50, 'level' => 'Expert', 'description' => 'Get 50 visits to your profile']);
        Achievement::create(['name' => '100 Profile Visits', 'type' => 'profile_visits', 'target' => 100, 'level' => 'Master', 'description' => 'Get 100 visits to your profile']);
        Achievement::create(['name' => '200 Profile Visits', 'type' => 'profile_visits', 'target' => 200, 'level' => 'Grandmaster', 'description' => 'Get 200 visits to your profile']);

        // Points Achievements
        Achievement::create(['name' => 'First 5 Points', 'type' => 'points', 'target' => 5, 'level' => 'Beginner', 'description' => 'Reach 5 points']);
        Achievement::create(['name' => 'First 10 Points', 'type' => 'points', 'target' => 10, 'level' => 'Intermediate', 'description' => 'Reach 10 points']);
        Achievement::create(['name' => 'First 25 Points', 'type' => 'points', 'target' => 25, 'level' => 'Advanced', 'description' => 'Reach 25 points']);
        Achievement::create(['name' => 'First 50 Points', 'type' => 'points', 'target' => 50, 'level' => 'Expert', 'description' => 'Reach 50 points']);
        Achievement::create(['name' => 'First 100 Points', 'type' => 'points', 'target' => 100, 'level' => 'Master', 'description' => 'Reach 100 points']);
        Achievement::create(['name' => 'First 200 Points', 'type' => 'points', 'target' => 200, 'level' => 'Grandmaster', 'description' => 'Reach 200 points']);

        // Streak Achievements (consecutive days logged in)
        Achievement::create(['name' => '3-Day Streak', 'type' => 'streak', 'target' => 3, 'level' => 'Beginner', 'description' => 'Login for 3 consecutive days']);
        Achievement::create(['name' => '7-Day Streak', 'type' => 'streak', 'target' => 7, 'level' => 'Intermediate', 'description' => 'Login for 7 consecutive days']);
        Achievement::create(['name' => '10-Day Streak', 'type' => 'streak', 'target' => 10, 'level' => 'Advanced', 'description' => 'Login for 10 consecutive days']);
        Achievement::create(['name' => '14-Day Streak', 'type' => 'streak', 'target' => 14, 'level' => 'Expert', 'description' => 'Login for 14 consecutive days']);
        Achievement::create(['name' => '30-Day Streak', 'type' => 'streak', 'target' => 30, 'level' => 'Master', 'description' => 'Login for 30 consecutive days']);
        Achievement::create(['name' => '45-Day Streak', 'type' => 'streak', 'target' => 45, 'level' => 'GrandMaster', 'description' => 'Login for 45 consecutive days']);

        // Total Achievements Unlocked
        Achievement::create(['name' => 'First 5 Achievements', 'type' => 'milestone', 'target' => 5, 'level' => 'Beginner', 'description' => 'Unlock 5 achievements']);
        Achievement::create(['name' => 'First 10 Achievements', 'type' => 'milestone', 'target' => 10, 'level' => 'Intermediate', 'description' => 'Unlock 10 achievements']);
        Achievement::create(['name' => 'First 20 Achievements', 'type' => 'milestone', 'target' => 20, 'level' => 'Advanced', 'description' => 'Unlock 20 achievements']);
        Achievement::create(['name' => 'First 30 Achievements', 'type' => 'milestone', 'target' => 30, 'level' => 'Expert', 'description' => 'Unlock 30 achievements']);
        Achievement::create(['name' => 'First 40 Achievements', 'type' => 'milestone', 'target' => 40, 'level' => 'Master', 'description' => 'Unlock 40 achievements']);
        Achievement::create(['name' => 'First 50 Achievements', 'type' => 'milestone', 'target' => 50, 'level' => 'GrandMaster', 'description' => 'Unlock 50 achievements']);
    }
}
