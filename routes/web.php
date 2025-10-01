<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;






Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth.role:gudang')->prefix('gudang')->group(function () {
    Route::get('/', function () { return view('gudang.dashboard'); });
});

Route::middleware(['auth.role:dapur'])->prefix('dapur')->group(function () {
    Route::get('/', function () { return view('dapur.dashboard'); });
});
