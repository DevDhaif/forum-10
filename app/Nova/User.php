<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

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
        'name',
        'email',
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

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required')
                ->updateRules('nullable'),

            Boolean::make('Is Admin')
                ->trueValue(1)
                ->falseValue(0)
                ->resolveUsing(function () {
                    return $this->hasRole('admin');
                })
                ->fillUsing(function ($request, $model, $attribute, $requestAttribute) {
                    if ($request->$requestAttribute) {
                        $model->assignRole('admin');
                    } else {
                        $model->removeRole('admin');
                    }
                }),


            HasMany::make('Threads', 'threads', Thread::class),
            HasMany::make('Questions', 'questions', Question::class),
            HasMany::make('Replies', 'replies', Reply::class),
            HasMany::make('Answers', 'answers', Answer::class),
            HasMany::make('Points', 'points', Point::class),
            BelongsToMany::make('Achievements', 'achievements', Achievement::class),
            BelongsTo::make('University')
                ->searchable()
                ->rules('required'),


            BelongsTo::make('Field')
                ->hide()
                ->dependsOn(['university'], function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    if ($formData->university) {
                        $field->show()->rules('required');
                    }
                }),

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
