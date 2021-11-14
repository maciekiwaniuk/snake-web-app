<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiSnakeGameController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1')->group(function() {
    Route::post('/logowanie-do-gry', [ApiSnakeGameController::class, 'login']);
    Route::post('/wczytanie-danych-tokenem', [ApiSnakeGameController::class, 'loadData']);
    Route::post('/zapisanie-danych-tokenem', [ApiSnakeGameController::class, 'saveData']);
    Route::post('/zapisanie-logu-wejsciowego', [ApiSnakeGameController::class, 'createOpenGameLog']);
    Route::post('/zapisanie-logu-wyjsciowego', [ApiSnakeGameController::class, 'createExitGameLog']);
    Route::post('/zapisanie-logu-wylogowania', [ApiSnakeGameController::class, 'createLogoutGameLog']);
});
