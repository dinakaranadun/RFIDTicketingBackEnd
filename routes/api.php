<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\PassengerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auth routes
Route::prefix('v1')->group(function () {
     // User routes
     Route::prefix('users')->group(function () {
        Route::post('create', [PassengerController::class, 'store']);
        // Add other user routes here if needed
        //train
        Route::get('traindetails', [TrainController::class, 'index']);
        Route::post('searchtrains', [TrainController::class, 'show']);
        //station
        Route::get('stationdetails', [StationController::class, 'index']);
    });
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        
        // Protected routes requiring authentication
        Route::middleware('auth:api')->group(function () {
            Route::post('logout', [AuthController::class, 'logout']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::post('me', [AuthController::class, 'me']);
        });
    });
});