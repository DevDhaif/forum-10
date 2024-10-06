<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Achievement extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'الإنجازات' : 'Achievements';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'إنجاز' : 'Achievement';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Achievement>
     */
    public static $model = \App\Models\Achievement::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'description',
        'type'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            Text::make(__('name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Textarea::make(__('description'), 'description')
                ->rules('required'),

            Select::make(__('type'), 'type')->options([
                'threads' => __('threads'),
                'questions' => __('questions'),
                'replies_count' => __('replies'),
                'answers_count' => __('answers'),
                'favorites' => __('favorites'),
                'votes' => __('votes'),
                'visits' => __('visits'),
                'profile_visits' => __('profile_visits'),
                'points' => __('points'),
                'streak' => __('streak'),
                'milestone' => __('milestone'),
            ])->displayUsingLabels()
                ->sortable()
                ->rules('required'),

            Number::make(__('target'), 'target')
                ->sortable()
                ->rules('required', 'min:1', 'max:1000000'),

            Select::make(__('level'), 'level')->options([
                'Beginner' => __('beginner'),
                'Intermediate' => __('intermediate'),
                'Advanced' => __('advanced'),
                'Expert' => __('expert'),
                'Master' => __('master'),
                'Grandmaster' => __('grandmaster'),
                'Legend' => __('legend'),
                'Champion' => __('champion'),
            ])->displayUsingLabels()
                ->sortable()
                ->rules('required'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
