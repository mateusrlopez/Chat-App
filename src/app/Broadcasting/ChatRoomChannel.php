<?php

namespace App\Broadcasting;

use App\Models\Channel;
use App\Models\User;

class ChatRoomChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(User $user, Channel $channel)
    {
        if($channel->users()->pluck('id')->contains($user->id))
            return ['id' => $user->id, 'name' => $user->name];
    }
}
