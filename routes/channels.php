<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Broadcast;

//presence channel for groups
Broadcast::channel('groups.{id}', function (User $user, $id) {
    if ($user->canJoinGroup($id)) {
        return $user;
    }
});
