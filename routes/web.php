<?php

use App\Http\Controllers\DisplayController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/reservation');
});

Route::middleware(['auth', 'specialist'])->group(function() {
    Route::get('/home', [UserController::class, 'index'])
        ->name('home');

    Route::post('/reservation/i/{id}/cancel', [ReservationController::class, 'cancelById'])
        ->name('reservation.cancel_by_id');

    Route::post('/reservation/i/{id}/start', [ReservationController::class, 'begin'])
        ->name('reservation.start');

    Route::post('/reservation/i/{id}/finish', [ReservationController::class, 'finish'])
        ->name('reservation.finish');

    Route::post('/status/available', [UserController::class, 'becomeAvailable'])
        ->name('status.available');

    Route::post('/status/unavailable', [UserController::class, 'becomeUnavailable'])
        ->name('status.unavailable');
});

Route::middleware('guest')->group(function () {
    Route::get('/reservation', [ReservationController::class, 'create'])
        ->name('reservation.create');

    Route::post('/reservation', [ReservationController::class, 'store'])
        ->name('reservation.store');

    Route::get('/reservation/{slug}', [ReservationController::class, 'show'])
        ->name('reservation.show');

    Route::post('/reservation/s/{slug}', [ReservationController::class, 'cancelBySlug'])
        ->name('reservation.cancel_by_slug');
});

Route::middleware(['auth', 'display'])->group(function () {
    Route::get('/display', [DisplayController::class, 'show'])
        ->name('display.show');

    Route::get('/display/home', function() {
       return view('display.home');
    })->name('display.home');
});

