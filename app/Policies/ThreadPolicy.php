<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ThreadPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->name === 'Dhaifallah') {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Thread $thread)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this thread.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Thread $thread)
    {
        return $thread->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this thread.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Thread $thread)
    {
        //
    }
}
