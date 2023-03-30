<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Websockets\MyCustomWebSocketHandler;
use BeyondCode\LaravelWebSockets\Facades\WebSocketsRouter;
use Illuminate\Support\Facades\Route;


// Route::post('/', function (Request $request) {
//     event(new \App\Events\NewMessage($request->message));
// });

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::post('/change-password', [ChangePasswordController::class, 'store']);

    //user-profile
    require __DIR__ . '/user-profile.php';

    //group
    require __DIR__ . '/group.php';

    //conversation
    require __DIR__ . '/conversation.php';

    //message
    require __DIR__ . '/message.php';


    //report
    require __DIR__ . '/report.php';
});
