<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PrivateController;
use App\Http\Requests\Channel\AttachUserChannelRequest;
use App\Http\Requests\Channel\UpdateUserChannelRequest;
use App\Models\Channel;
use App\Models\User;

class ChannelUserController extends PrivateController
{
    public function index(Channel $channel)
    {
        return $channel->users;
    }

    public function store(AttachUserChannelRequest $request, Channel $channel)
    {
        $validatedData = $request->validated();
        $channel->users()->attach($validatedData['user_id'], ['admin' => $validatedData['admin']]);
        return response()->json('', 204);
    }

    public function update(UpdateUserChannelRequest $request, Channel $channel, User $user)
    {
        $channel->users()->updateExistingPivot($user->id, $request->validated());
        return response()->json('', 204);
    }

    public function delete(Channel $channel, User $user)
    {
        $channel->users()->detach($user->id);
        return response()->json('', 204);
    }
}
