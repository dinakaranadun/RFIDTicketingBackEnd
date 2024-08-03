<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RFIDController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\SchedualeController;


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
        //ticket
        Route::post('calculate-ticket-cost',[TicketController::class,'index']);
        Route::post('bookTicket',[TicketController::class,'store']);
        Route::post('upcomingTrips',[TicketController::class,'show']);
        Route::delete('deleteBooking/{bookingId}', [TicketController::class, 'destroy']);
        //scheduale
        Route::post('searchscheduale', [SchedualeController::class, 'search']);

        //rfid
        Route::post('handleRFID', [RFIDController::class, 'handleRFID']);

        //forum
        Route::post('createForum', [ForumController::class, 'store']);
        Route::get('getForum', [ForumController::class, 'index']);
        Route::put('updateForum/{id}', [ForumController::class, 'edit']);
        Route::delete('deleteForum/{id}', [ForumController::class, 'destroy']);

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