<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PrivateController;
use App\Models\User;

class UserFriendshipRequestReceivedController extends PrivateController
{
    public function index(User $user)
    {
        return $user->friendshipRequestsReceived()->join('users', 'friend_requests.sender_id', '=', 'users.id')->select('friend_requests.*', 'users.name')->get();
    }
}
