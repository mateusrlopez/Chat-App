<?php

namespace App\Broadcasting;

use App\Models\User;

class UserChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, int $id)
    {
        return $user->id === $id;
    }
}
