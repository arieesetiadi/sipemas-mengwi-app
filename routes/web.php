<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\System\AdminController;
use App\Http\Controllers\System\DashboardController;
use App\Http\Controllers\System\LoginController;
use App\Http\Controllers\System\LogoutController;
use App\Http\Controllers\System\PendudukController;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\GuestAdmin;
use App\Http\Middleware\MainHandler;

// PORTAL (Penduduk)
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

        // route status dulu biar nggak ketuker sama route resource
        Route::patch('/admin/{admin}/status', [AdminController::class, 'updateStatus'])->name('admin.status');
        Route::resource('admin', AdminController::class)->except(['show', 'destroy']);

        Route::patch('/penduduk/{penduduk}/status', [PendudukController::class, 'updateStatus'])->name('penduduk.status');
        Route::resource('penduduk', PendudukController::class)->except(['show', 'destroy']);

        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});
