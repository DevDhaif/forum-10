<?php

namespace App\Nova;

use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Support\Str;

class Answer extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'الإجابات' : 'Answers';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'إجابة' : 'Answer';
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('votes');
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Answer>
     */
    public static $model = \App\Models\Answer::class;

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

            Text::make(__('body'), function () {
                return Str::limit(strip_tags($this->body), limit: 50);
            })->onlyOnIndex(),
            Markdown::make(__('body'), 'body')
                ->rules('required')
                ->hideFromIndex(),
            BelongsTo::make(__('user'), 'owner', User::class)
                ->readonly()
                ->sortable(),
            Number::make(__('votes_count'), 'votes_count')
                ->readonly()
                ->sortable(),
            BelongsTo::make(__('question'), 'question', Question::class)->readonly(),
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
