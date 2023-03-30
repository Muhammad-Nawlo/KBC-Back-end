<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Events\UpdateMessage;
use App\Http\Requests\MessageRequest;
use App\Models\Message;

class MessageController extends Controller
{
    public function store(MessageRequest $request)
    {
        $message = auth()->user()->messages()->create($request->only([
            "conversation_id",
            "body",
        ]));
        if ($request->hasFile('file')) {
            $message->addMedia($request->file('file'))->toMediaCollection('messageFile');
        }
        event(new NewMessage());
        return response()->json(['status' => true]);
    }

    public function update(MessageRequest $request, Message $message)
    {
        $message->update($request->only(['body']));

        if ($request->hasFile('file')) {
            $message->addMedia($request->file('file'))->toMediaCollection('messageFile');
        }

        event(new UpdateMessage());
        return response()->json(['status' => true]);
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return response()->json([
            'status' => true
        ]);
    }
}
