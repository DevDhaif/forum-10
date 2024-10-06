<?php

namespace App\Nova;

use Illuminate\Support\Facades\App;
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
    public static function label()
    {
        // Use localization for plural label (e.g., "Users")
        return App::isLocale('ar') ? 'المستخدمين' : 'Users';
    }

    public static function singularLabel()
    {
        // Use localization for singular label (e.g., "User")
        return App::isLocale('ar') ? 'مستخدم' : 'User';
    }
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

            Text::make(__('name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__('email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Password::make(__('password'), 'password')
                ->onlyOnForms()
                ->creationRules('required')
                ->updateRules('nullable'),

            Boolean::make(__('is_admin'), 'is_admin')
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


            HasMany::make(__('threads'), 'threads', Thread::class),
            HasMany::make(__('questions'), 'questions', Question::class),
            HasMany::make(__('replies'), 'replies', Reply::class),
            HasMany::make(__('answers'), 'answers', Answer::class),
            HasMany::make(__('points'), 'points', Point::class),
            BelongsToMany::make(__('achievements'), 'achievements', Achievement::class),
            BelongsTo::make(__('University'), 'university', University::class)
                ->searchable()
                ->rules('required'),

            BelongsTo::make(__('field'), 'field', Field::class)
                ->hide()  // Initially hide the field
                ->dependsOn(['university'], function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    if ($formData->university) {
                        // Show the field and make it required if a university is selected
                        $field->show()->rules('required');
                    } else {
                        // Hide the field if no university is selected
                        $field->hide();
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
