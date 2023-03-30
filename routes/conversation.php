<?php

use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('conversation',ConversationController::class);
