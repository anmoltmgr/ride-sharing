<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/verify-login', [LoginController::class, 'verifyLogin']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/driver', [DriverController::class, 'show']);
    Route::post('/driver', [DriverController::class, 'create']);
});
