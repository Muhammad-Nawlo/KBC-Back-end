<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => ConversationResource::collection(auth()->user()->conversations)
        ]);
    }

    public function show(Conversation $conversation)
    {
        return response()->json(['status' => true, 'data' => new ConversationResource($conversation->load('messages'))]);
    }

    public function store(ConversationRequest $request)
    {
        $conversation = Conversation::query()->create($request->validated());
        return response()->json([
            'status' => true,
            'data' => new ConversationResource($conversation)
        ]);
    }

    public function destroy(Conversation $conversation)
    {
        $conversation->delete();

        return response()->json([
            'status' => true
        ]);
    }
}
