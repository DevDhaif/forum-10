<?php

namespace App\Nova;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Reply extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'الردود' : 'Replies';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'رد' : 'Reply';
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('favorites');
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Reply>
     */
    public static $model = \App\Models\Reply::class;

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

            Text::make(__('body'), 'body')
                ->sortable()
                ->rules('required', 'max:255'),
            BelongsTo::make(__('creator'), 'owner', User::class)
                ->readonly()
                ->sortable(),
            Number::make(__('favorites_count'), 'favorites_count')
                ->readonly()
                ->sortable(),
            BelongsTo::make(__('thread'), 'thread', Thread::class)->readonly(),
            // Textarea::make(__('body'), 'body')
            //     ->rules('required'),
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
