<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Thread extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'المواضيع' : 'Threads';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'موضوع' : 'Thread';
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        // Ensure that favorites_count is included in the query for sorting
        return $query->withCount('favorites');
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Thread>
     */
    public static $model = \App\Models\Thread::class;

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
            Text::make(__('title'), 'title')
                ->sortable()
                ->rules('required', 'max:255'),

            Markdown::make(__('body'), 'body')
                ->rules('required'),

            // Display the user who created the thread
            BelongsTo::make(__('creator'), 'creator', User::class)
                ->readonly()
                ->sortable(),


            BelongsTo::make(__('channel'), 'channel', Channel::class)->display('name')->readonly(),
            // Display the number of replies
            Number::make('Replies Count')
                ->onlyOnDetail()
                ->sortable(),

            Number::make(__('favorites_count'), 'favorites_count')->readonly()->sortable(),
            // Display the number of visits
            Number::make(__('visits'), 'visits')
                ->readonly()
                ->sortable(),
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
