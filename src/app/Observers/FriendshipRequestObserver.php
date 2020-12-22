<?php

namespace App\Observers;

use App\Models\FriendshipRequest;
use App\Notifications\FriendshipRequestReceivedNotification;

class FriendshipRequestObserver
{
    public function created(FriendshipRequest $friendshipRequest)
    {
        $friendshipRequest->receiver->notify(new FriendshipRequestReceivedNotification($friendshipRequest));
    }
}
