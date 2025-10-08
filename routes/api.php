<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ZegoController;
use App\Http\Controllers\ZegoTokenController;
use App\Http\Controllers\Api\StreamController;


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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/zego/token', [ZegoController::class, 'getToken']);
Route::get('/zegotoken',[ZegoTokenController::class, 'issue']);

Route::middleware('auth:sanctum')->group(function () {

    // Route to get the currently logged-in user's details
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // --- Add these new routes for streaming ---

    // Route for the web app to start a stream
    Route::post('/streams/start', [StreamController::class, 'start']);

    // Route for the web app to stop a stream
    Route::post('/streams/stop', [StreamController::class, 'stop']);

    // Route for the Flutter app to get all active streams
    Route::get('/streams/active', [StreamController::class, 'getActiveStreams']);

});


