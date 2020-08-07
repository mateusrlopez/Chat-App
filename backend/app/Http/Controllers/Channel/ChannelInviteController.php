<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\Invite\CreateInviteRequest;
use App\Models\Channel;
use App\Models\Invite;
use Illuminate\Support\Facades\Auth;

class ChannelInviteController extends PrivateController
{
    public function index(Channel $channel)
    {
        return $channel->invites;
    }

    public function create(CreateInviteRequest $request, Channel $channel)
    {
        $invite = $channel->invites()->create($request->validated() + ['inviter_id' => Auth::id()]);
        return response()->json($invite, 201);
    }

    public function delete(Invite $invite)
    {
        $invite->delete();
        return response()->json('', 204);
    }
}
