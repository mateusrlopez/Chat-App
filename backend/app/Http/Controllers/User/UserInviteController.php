<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\PrivateController;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserInviteController extends PrivateController
{
    public function index(User $user)
    {
        return $user->invitesReceived;
    }

    public function accept(Invite $invite)
    {
        DB::transaction(function () use ($invite){
            $invite->channel->users()->attach($invite->userReceived->id);
            $invite->delete();
        });
        return response()->json('', 204);
    }

    public function refuse(Invite $invite)
    {
        $invite->delete();
        return response()->json('', 204);
    }
}
