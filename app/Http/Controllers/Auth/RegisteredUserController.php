<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{

    public function store(RegisterUserRequest $request)
    {
        $request = $request->validated();
        try {
            DB::beginTransaction();
            $user = User::create($request['user']);
            $userProfile = $user->userProfile()->create($request['user_profile']);
            if ($request['user_profile']['image']) {
                $userProfile->addMedia($request['user_profile']['image'])->toMediaCollection('userImages');
            }
            $userProfile->interestings()->sync($request['user_profile']['interesting']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }

        $token = $user->createToken('kbc')->plainTextToken;
        DB::commit();
        event(new Registered($user));
        return response()->json(['status' => true, 'token' => $token, 'data' => new UserResource($user->load('userProfile'))]);
    }
}
