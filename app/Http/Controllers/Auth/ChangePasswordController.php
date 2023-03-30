<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ChangePasswordController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'different:old_password', Password::default()]
        ]);

        $request->user()->update(['password' => Hash::make($request->password)]);

        return response()->json(['status' => true]);
    }
}
