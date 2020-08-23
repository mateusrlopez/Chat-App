<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\Channel\CreateUpdateChannelRequest;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChannelController extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Channel::class, 'channel', ['except' => ['index', 'store']]);    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Channel::filterQuery()->withCount('users')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateChannelRequest $request) 
    {
        $channel = null;
        
        DB::transaction(function () use ($request, &$channel) {
            $channel = Channel::create($request->validated());
            $channel->users()->attach(Auth::id());
        });

        return response()->json($channel, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        $channel->users()->updateExistingPivot(Auth::id(), ['last_activity' => now()]);
        return $channel;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateChannelRequest $request, Channel $channel)
    {
        $channel->update($request->validated());
        return response()->json('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();
        return response()->json('', 204);
    }
}
