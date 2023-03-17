<?php

namespace App\Providers;

// use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\View as View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // send all channels to all views
        view()->composer('*', function ($view) {
            $view->with('channels', \App\Models\Channel::all());
        });
    }
}
