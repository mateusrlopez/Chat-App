<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\PrivateController;
use App\Http\Requests\Message\CreateUpdateMessageRequest;
use App\Models\Message;

class MessageController extends PrivateController
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateMessageRequest $request, Message $message)
    {
        $message->update($request->validated());
        return response()->json('', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return response()->json('', 204);
    }
}
