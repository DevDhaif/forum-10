<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Channel extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'القنوات' : 'Channels';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'قناة' : 'Channel';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Channel>
     */
    public static $model = \App\Models\Channel::class;

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

            Text::make(__('slug'), 'slug')
                ->sortable()
                ->rules('required', 'max:255'),

            Number::make(__('total_threads'), function () {
                return $this->threads_count ?? 0;  // Fallback to 0 if null
            })->sortable(),

            // Use translation key for Total Questions
            Number::make(__('total_questions'), function () {
                return $this->questions_count ?? 0;  // Fallback to 0 if null
            })->sortable(),

            // Use translation key for Total Contributions (calculated field)
            Number::make(__('total_contributions'), function () {
                return ($this->threads_count ?? 0) + ($this->questions_count ?? 0);
            })->sortable(),
            HasMany::make(__('questions'), 'questions', Question::class),
            HasMany::make(__('threads'), 'threads', Thread::class),
        ];
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount(['threads', 'questions']);
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
