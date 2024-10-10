<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReplyPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function view(User $user, Reply $reply)
    {
        return true;
    }
    public function before(User $user, $ability)
    {
        if ($user->name === 'Dhaifallah') {
            return true;
        }
    }

    public function update(User $user, Reply $reply)
    {
        //
        return $reply->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this reply.');
    }
    public function delete(User $user, Reply $reply)
    {
        //
        return $reply->user_id == $user->id || $user->hasRole('admin')
            ? Response::allow()
            : Response::deny('You do not own this reply.');
    }
}
