<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/verify-login', [LoginController::class, 'verifyLogin']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/driver', [DriverController::class, 'show']);
    Route::post('/driver', [DriverController::class, 'create']);

    Route::post('/trip', [TripController::class, 'create']);
    Route::get('trip/{trip}', [TripController::class, 'show']);

    Route::post('trip/{trip}/accept', [TripController::class, 'accept']);
    Route::post('trip/{trip}/start', [TripController::class, 'start']);
    Route::post('trip/{trip}/end', [TripController::class, 'end']);
    Route::post('trip/{trip}/location', [TripController::class, 'location']);
});
