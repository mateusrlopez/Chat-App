<?php

namespace App\Observers;

use App\Models\Invite;
use App\Notifications\InviteReceivedNotification;

class InviteObserver
{
    public function created(Invite $invite)
    {
        $invite->invited->notify(new InviteReceivedNotification($invite));
    }
}
