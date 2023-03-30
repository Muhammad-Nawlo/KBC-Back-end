<?php

namespace App\Http\Controllers;

use App\Enums\ConversationStatusEnum;
use App\Enums\GroupPrivilegeEnum;
use App\Enums\GroupStatusEnum;
use App\Http\Requests\GroupRequest;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index()
    {
        $interesting = Auth::user()->userProfile->interestings->pluck('id')->toArray();
        return response()->json([
            'status' => true,
            'data' => GroupResource::collection(Group::query()->related($interesting)->with('interestings')->inRandomOrder()->limit(10)->get())
        ]);
    }

    public function show(Group $group)
    {
        return response()->json([
            'status' => true,
            'data' => new GroupResource($group->load(['interestings', 'users'])),
        ]);
    }

    public function store(GroupRequest $request)
    {
        try {
            DB::beginTransaction();
            $group = Group::create(array_merge($request->only(
                "title",
                "group_name",
                'about',
                'max_member',
                'group_type_id',
                'user_can_join_directly')
                , ['status' => GroupStatusEnum::ACTIVE()->value]));
            if ($request->hasFile('image')) {
                $group->addMedia($request->file('image'))->toMediaCollection('groupImages');
            }
            $group->interestings()->sync($request->interesting);

            //create a conversation for this group
            auth()->user()->groups()->attach($group, [
                'id' => Str::orderedUuid(),
                'group_privilege' => GroupPrivilegeEnum::ADMIN(),
                'is_mute' => 0,
                'is_favorite' => 0,
                'status' => ConversationStatusEnum::ACTIVE(),
                'rate' => 0,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }

        DB::commit();
        return response()->json(['status' => true, 'data' => new GroupResource($group->load('interestings'))]);
    }

    public function update(GroupRequest $request, Group $group)
    {
        $group->update($request->only(
            "title",
            "group_name",
            'about',
            'max_member',
            'group_type_id',
            'user_can_join_directly'
        ));
        if ($request->hasFile('image')) {
            $group->addMedia($request->file('image'))->toMediaCollection('groupImages');
        }

        return response()->json(['status' => true, 'data' => new GroupResource($group->load('interestings'))]);
    }

    public function destroy(Group $group)
    {
        $group->delete();

        return response()->json(['status' => true]);

    }

    public function join(Request $request, Group $group)
    {
        //@todo logic for send a request to join a group
        $request->user()->groups()->attach($group,[

        ]);
    }

    public function leave(Request $request, Group $group)
    {
        $request->user()->groups()->detach($group);
    }
}
