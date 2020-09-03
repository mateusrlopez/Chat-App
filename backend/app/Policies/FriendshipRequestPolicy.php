<?php

namespace App\Policies;

use App\Models\FriendshipRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FriendshipRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can accept the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FriendshipRequest  $friendshipRequest
     * @return mixed
     */
    public function accept(User $user, FriendshipRequest $friendshipRequest)
    {
        return $user->is($friendshipRequest->receiver);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FriendshipRequest  $friendshipRequest
     * @return mixed
     */
    public function delete(User $user, FriendshipRequest $friendshipRequest)
    {
        return $user->is($friendshipRequest->receiver);
    }
}
