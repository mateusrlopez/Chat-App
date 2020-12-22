<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\FriendshipRequest\CreateFriendshipRequestRequest;
use App\Models\FriendshipRequest;
use App\Models\User;

class UserFriendshipRequestSentController extends PrivateController
{
    public function store(CreateFriendshipRequestRequest $request, User $user)
    {
        $friendRequest = new FriendshipRequest($request->validated());
        $user->friendshipRequestsSent()->save($friendRequest);
        return $friendRequest;
    }
}
