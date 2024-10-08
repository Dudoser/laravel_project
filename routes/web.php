<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAuthenticated;
use App\Http\Middleware\CheckToken;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [MainController::class, 'indexAction'])->name('indexAction');

Route::get('/login', [AuthController::class, 'showLoginFormAction'])->name('login.form');
Route::get('/register', [AuthController::class, 'showRegisterFormAction'])->name('register.form');
Route::post('/login', [AuthController::class, 'loginAction'])->name('loginAction');
Route::post('/register', [AuthController::class, 'registrationAction'])->name('registrationAction');
Route::post('/logout', [AuthController::class, 'logoutAction'])->name('logoutAction');

Route::middleware([CheckAuthenticated::class, CheckToken::class])->group(function () {
    Route::get('/pageA/{token}', [TokenController::class, 'showSpecialPage'])->name('special.page');
    Route::get('/token/history', [TokenController::class, 'showHistory'])->name('token.history');
    Route::post('/token/generate', [TokenController::class, 'generateNewToken'])->name('token.generate');
    Route::post('/token/deactivate', [TokenController::class, 'deactivateToken'])->name('token.deactivate');
    Route::post('/token/lucky', [TokenController::class, 'imFeelingLucky'])->name('token.lucky');
});
