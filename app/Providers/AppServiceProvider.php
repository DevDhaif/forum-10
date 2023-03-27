<?php

namespace App\Providers;

// use Illuminate\Contracts\View\View;

use Illuminate\Support\Facades\Cache;
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
        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
         * Bootstrap any application services.
         */
    public function boot(): void
    {
        // send all channels to all views
        view()->composer('*', function ($view) {
            $channels = Cache::rememberForever(
                'channels',
                function () {
                return \App\Models\Channel::all();
            }
            );
            $view->with('channels',$channels);
        });
    }
}
