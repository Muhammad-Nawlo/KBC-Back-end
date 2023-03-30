<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Message;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function message(Request $request, Message $message)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);
        $message->reports()->create([
            'message' => $request->message,
        ]);

        return response()->json(['status' => true]);
    }

    public function user(Request $request, User $user)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);
        $user->reports()->create([
            'message' => $request->message
        ]);

        return response()->json(['status' => true]);
    }

    public function group(Request $request, Group $group)
    {
        $request->validate([
            'message' => ['required', 'string'],
        ]);
        $group->reports()->create([
            'message' => $request->message,
        ]);
        return response()->json(['status' => true]);
    }
}
