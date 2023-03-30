<?php

namespace App\Http\Controllers;

use App\Models\GroupType;
use Illuminate\Http\Request;

class GroupTypeController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'status' => true,
            'data' => GroupType::all()
        ]);
    }
}
