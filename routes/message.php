<?php

use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::apiResource('message', MessageController::class);
