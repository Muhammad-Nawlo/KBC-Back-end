<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::post('report/{message}/message', [ReportController::class, 'message']);
Route::post('report/{user}/user', [ReportController::class, 'user']);
Route::post('report/{group}/group', [ReportController::class, 'group']);
