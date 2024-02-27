<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(static function (): void {
    Route::post('register', \App\Http\Controllers\Auth\RegisterController::class);

    Route::middleware('throttle:3,1')
        ->post('login', \App\Http\Controllers\Auth\LoginController::class);

    Route::middleware('auth:sanctum')->group(static function (): void {
        Route::post('logout/current', \App\Http\Controllers\Auth\LogoutCurrentController::class);
        Route::post('logout/all', \App\Http\Controllers\Auth\LogoutAllController::class);
        Route::get('me', \App\Http\Controllers\Auth\MeController::class);
    });
});

Route::middleware('auth:sanctum')->group(static function (): void {
    Route::prefix('reservations')->group(static function (): void {
        Route::post('', \App\Http\Controllers\Reservation\ReservationStoreController::class);
        Route::get('', \App\Http\Controllers\Reservation\ReservationIndexController::class);
        Route::get('{id}', \App\Http\Controllers\Reservation\ReservationShowController::class);
        Route::put('{id}', \App\Http\Controllers\Reservation\ReservationUpdateController::class);
        Route::delete('{id}', \App\Http\Controllers\Reservation\ReservationDestroyController::class);
    });
});
