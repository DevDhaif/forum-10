<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function __construct()
    {
        //
    }
    public function before(User $user, $ability)
    {
        if ($user->name === 'Dhaifallah') {
            return true;
        }
    }


    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Answer $answer)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Answer $answer): Response
    {
        return $answer->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this answer.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Answer $answer): Response
    {
        return $answer->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this answer.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Answer $answer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Answer $answer)
    {
        //
    }
}
