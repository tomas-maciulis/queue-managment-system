<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/reservation');
});

Route::get('/home', function () {
    return view('home');
})->middleware('auth');

Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/{slug}', [ReservationController::class, 'show'])->name('reservation.show');
Route::post('/reservation/{slug}', [ReservationController::class, 'cancel'])->name('reservation.cancel');
