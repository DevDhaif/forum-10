<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\ActiveUsers;
use App\Nova\Metrics\AnswersPerDay;
use App\Nova\Metrics\MostPopularQuestions;
use App\Nova\Metrics\MostPopularThreads;
use App\Nova\Metrics\QuestionsPerDay;
use App\Nova\Metrics\RepliesPerDay;
use App\Nova\Metrics\ThreadsPerDay;
use App\Nova\Metrics\TotalAnswers;
use App\Nova\Metrics\TotalQuestions;
use App\Nova\Metrics\TotalReplies;
use App\Nova\Metrics\TotalThreads;
use App\Nova\Metrics\TotalUsers;
use App\Nova\Metrics\UserGrowth;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function name()
    {
        return __('stats');
    }
    public function cards()
    {
        return [
            new TotalUsers(),
            new TotalQuestions(),
            new TotalThreads(),
            new TotalReplies(),
            new TotalAnswers(),
            new ActiveUsers(),
            new MostPopularThreads(),
            new MostPopularQuestions(),
            new UserGrowth(),
            new UsersPerDay(),
            new ThreadsPerDay(),
            new QuestionsPerDay(),
            new AnswersPerDay(),
            new RepliesPerDay(),
            // new Help,

        ];
    }
}
