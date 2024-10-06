<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Question extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'الأسئلة' : 'Questions';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'سؤال' : 'Question';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Question>
     */
    public static $model = \App\Models\Question::class;

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

            BelongsTo::make(__('creator'), 'creator', User::class)
                ->readonly()
                ->sortable(),
            Number::make(__('votes_count'), 'votes_count')
                ->readonly()
                ->sortable(),
            Boolean::make(__('has_answers'), 'is_answered')
                ->sortable(),
            Boolean::make(__('is_sloved'), 'is_solved')
                ->sortable(),
            Number::make(__('upvotes_count'), function () {
                return $this->upvotes()->count();
            }),

            Number::make(__('downvotes_count'), function () {
                return $this->downvotes()->count();
            })
                ->sortable(),

            BelongsTo::make(__('channel'), 'channel', Channel::class)->display('name'),
            Number::make('Answers Count')
                ->onlyOnDetail()
                ->sortable(),

            Number::make(__('visits'), 'visits')
                ->onlyOnDetail()
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
