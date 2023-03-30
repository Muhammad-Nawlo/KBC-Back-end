<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function show()
    {
        return response()->json(['status' => true, 'data' => new UserResource(Auth::user())]);
    }

    public function update(UpdateUserRequest $request)
    {
        if ($request->hasFile('image')) {
            auth()->user()->userProfile()->addFromMediaLibraryRequest($request->file('image'))->toMediaCollection('userImages');
        }

        $request = $request->validated();

        auth()->user()->userProfile()->update($request['user_profile']);

        auth()->user()->userProfile->interestings()->sync($request['interesting']);

        return response()->json(['status' => true, 'data' => new UserResource(Auth::user())]);
    }
}
