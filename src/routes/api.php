<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ParkingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LocationLogController;
use App\Http\Controllers\Api\RegisterController;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.auth')->group(function () {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class);
    
    Route::get('parkings', [ParkingController::class, 'index']) ; 
    Route::post('parkings', [ParkingController::class, 'store']);
    Route::get('parkings/{id}', [ParkingController::class, 'show'])->where('id', '[0-9]+'); 
    Route::delete('parkings/{id}', [ParkingController::class, 'destroy'])->where('id', '[0-9]+'); 
    Route::get('parkings/buscar-cercano', [ParkingController::class, 'buscarMasCercano']);
    
    Route::get('logs/distantes', [LocationLogController::class, 'index']);
});


