<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\Invite\CreateInviteRequest;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;

class ChannelInviteController extends PrivateController
{
    public function index(Channel $channel)
    {
        return $channel->invites;
    }

    public function store(CreateInviteRequest $request, Channel $channel)
    {
        $invite = $channel->invites()->create($request->validated() + ['inviter_id' => Auth::id()]);
        return response()->json($invite, 201);
    }
}
