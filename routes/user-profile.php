<?php

use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/get-profile', [UserProfileController::class, 'show']);
Route::post('/update-profile', [UserProfileController::class, 'update']);
