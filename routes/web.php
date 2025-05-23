<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ForumController;
use App\Http\Controllers\Admin\RouteController;
use App\Http\Controllers\Admin\TrainController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StationController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PassengerController;
use App\Http\Controllers\Admin\TrainClassController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PassengerFlowController;
use App\Http\Controllers\Admin\RevenueReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employee', EmployeeController::class);
    Route::resource('station', StationController::class);
    Route::resource('train', TrainController::class);
    Route::resource('route', RouteController::class);
    Route::resource('schedule', ScheduleController::class);
    Route::resource('passenger', PassengerController::class);
    Route::resource('forum', ForumController::class);
    Route::resource('notification', NotificationController::class);
    Route::resource('refund', RefundController::class);
    Route::put('/refund/{ticket}/{passenger}', [RefundController::class, 'update'])->name('refund.update');
    Route::resource('report',ReportController::class);
    Route::resource('passengerflow',PassengerFlowController::class);
    Route::get('/reports/passenger-flow/generate', [PassengerFlowController::class, 'generateReport'])->name('report.passengerFlowGenerate');
    Route::resource('revenue', RevenueReportController::class);
    Route::get('/reports/revenue/generate', [RevenueReportController::class, 'generateRevenueReport'])->name('report.revenueGenerate');


    Route::post('send-sms', [SMSController::class, 'sendSms']);
});
