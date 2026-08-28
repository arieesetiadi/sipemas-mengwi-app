<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\System\DashboardController;
use App\Http\Controllers\System\LoginController;
use App\Http\Controllers\System\LogoutController;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\GuestAdmin;
use App\Http\Middleware\MainHandler;

// PORTAL (Masyarakat)
Route::as('portal.')->middleware(MainHandler::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// ---------------------------------

// SYSTEM (Admin/Internal)
Route::prefix('system')->as('system.')->middleware(MainHandler::class)->group(function () {
    Route::middleware(GuestAdmin::class)->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login.index');
        Route::post('/login', [LoginController::class, 'validate'])->name('login.validate');
    });

    Route::middleware(AuthenticateAdmin::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
