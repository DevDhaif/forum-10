<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class University extends Resource
{
    public static function label()
    {
        return App::isLocale('ar') ? 'الجامعات' : 'Universities';
    }

    public static function singularLabel()
    {
        return App::isLocale('ar') ? 'جامعة' : 'University';
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\University>
     */
    public static $model = \App\Models\University::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name'
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
            Text::make(__('name'), 'name')->sortable()->rules('required', 'max:255'),
            HasMany::make('Fields', 'fields', Field::class),
            HasMany::make(__('users'), 'users', User::class),
            Number::make(__('users_count'), function () {
                return $this->users_count;
            })->sortable(),
            Number::make(__('fields_count'), function () {
                return $this->fields_count;
            })->sortable(),
        ];
    }
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->withCount('users');
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
