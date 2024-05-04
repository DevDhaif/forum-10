<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question)
    {
        return $question->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this question.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question)
    {
        return $question->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this question.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Question $question)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Question $question)
    {
        //
    }
}
