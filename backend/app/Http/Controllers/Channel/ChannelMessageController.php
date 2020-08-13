<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\Message\CreateUpdateMessageRequest;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;

class ChannelMessageController extends PrivateController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel)
    {
        return $channel->messages;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateMessageRequest $request, Channel $channel)
    {
        $message = $channel->messages()->create(($request->validated() + ['user_id' => Auth::id()]));
        return response()->json($message, 201);
    }
}
