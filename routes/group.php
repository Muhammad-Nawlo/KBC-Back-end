<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::apiResource('group', GroupController::class);

