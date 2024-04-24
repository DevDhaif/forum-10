<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        \App\Models\Thread::class => \App\Policies\ThreadPolicy::class,
        \App\Models\Reply::class => \App\Policies\ReplyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
        $this->registerPolicies();

        Gate::define('update-thread', function ($user, $thread) {
            return $user->id == $thread->user_id;
        });

        Gate::define('delete-thread', function ($user, $thread) {
            return $user->id == $thread->user_id;
        });
        // Gate::before(function ($user) {
        //     if ($user->name === 'Dhaifallah') {
        //         return true;
        //     }
        // });
    }
}
