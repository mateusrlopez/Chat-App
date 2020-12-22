<?php

namespace App\Policies;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can accept the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invite  $invite
     * @return mixed
     */
    public function accept(User $user, Invite $invite)
    {
        return $user->is($invite->invited);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Invite  $invite
     * @return mixed
     */
    public function delete(User $user, Invite $invite)
    {
        return $user->is($invite->invited) or $user->is($invite->channel->owner) or $invite->channel->administrators->pluck('id')->contains($user->id); 
    }
}
