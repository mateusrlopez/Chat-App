<?php

namespace App\Policies;

use App\Models\Channel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Channel  $channel
     * @return mixed
     */
    public function view(User $user, Channel $channel)
    {
        return $channel->users->pluck('user_id')->contains($user->id);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Channel  $channel
     * @return mixed
     */
    public function update(User $user, Channel $channel)
    {
        return $channel->owner->is($user) or $channel->administrators->pluck('user_id')->contains($user->id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Channel  $channel
     * @return mixed
     */
    public function delete(User $user, Channel $channel)
    {
        return $channel->owner->is($user);
    }

    public function accessRelated(User $user, Channel $channel)
    {
        return $channel->users->pluck('id')->contains($user->id);
    }

    public function manageRelated(User $user, Channel $channel)
    {
        return $channel->owner->is($user) or $channel->administrators->pluck('user_id')->contains($user->id);
    }
}
