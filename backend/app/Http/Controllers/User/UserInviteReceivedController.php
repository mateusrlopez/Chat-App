<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PrivateController;
use App\Models\User;

class UserInviteReceivedController extends PrivateController
{
    public function index(User $user)
    {
        return $user->invitesReceived;
    }
}
