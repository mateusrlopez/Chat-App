<?php

namespace App\Http\Controllers\Channel;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\Message\CreateUpdateMessageRequest;
use App\Models\Channel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\CommonMarkConverter;

class ChannelMessageController extends PrivateController
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Channel::class, 'channel');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel)
    {
        return $channel->messages()->join('users', 'messages.user_id', '=', 'users.id')->select('messages.*', 'users.name')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateMessageRequest $request, CommonMarkConverter $converter, Channel $channel)
    {   
        $message = null;
        DB::transaction(function () use ($channel, $request, $converter, &$message){
            $message = $channel->messages()->create(['content' => $converter->convertToHtml($request->validated()['content']), 'user_id' => Auth::id()]);
            $channel->users()->updateExistingPivot(Auth::id(), ['last_activity' => now()]);
        });
        return response()->json($message, 201);
    }

    protected function resourceAbilityMap()
    {
        return [
            'index' => 'accessRelated',
            'store' => 'accessRelated'
        ];
    }

    protected function resourceMethodsWithoutModels()
    {
        return [];
    }
}
