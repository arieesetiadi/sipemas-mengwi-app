<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\Portal\LoginController;
use App\Http\Controllers\Portal\LogoutController;
use App\Http\Controllers\Portal\RegisterController;
use App\Http\Controllers\System\AdminController;
use App\Http\Controllers\System\DashboardController;
use App\Http\Controllers\System\LoginController as SystemLoginController;
use App\Http\Controllers\System\LogoutController as SystemLogoutController;
use App\Http\Controllers\System\PendudukController;
use App\Http\Middleware\AuthenticateAdmin;
use App\Http\Middleware\AuthenticatePortal;
use App\Http\Middleware\GuestAdmin;
use App\Http\Middleware\GuestPortal;
use App\Http\Middleware\MainHandler;

// PORTAL (Penduduk)
Route::as('portal.')->middleware(MainHandler::class)->group(function () {
    Route::middleware(GuestPortal::class)->group(function () {
        Route::get('/login', [LoginController::class, 'index'])->name('login.index');
        Route::post('/login', [LoginController::class, 'validate'])->name('login.validate');

        Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
        Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    });

    Route::middleware(AuthenticatePortal::class)->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});

// ---------------------------------

// SYSTEM (Admin/Internal)
Route::prefix('system')->as('system.')->middleware(MainHandler::class)->group(function () {
    Route::middleware(GuestAdmin::class)->group(function () {
        Route::get('/login', [SystemLoginController::class, 'index'])->name('login.index');
        Route::post('/login', [SystemLoginController::class, 'validate'])->name('login.validate');
    });

    Route::middleware(AuthenticateAdmin::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::patch('/admin/{admin}/status', [AdminController::class, 'updateStatus'])->name('admin.status');
        Route::resource('admin', AdminController::class)->except(['show', 'destroy']);

        Route::patch('/penduduk/{penduduk}/status', [PendudukController::class, 'updateStatus'])->name('penduduk.status');
        Route::resource('penduduk', PendudukController::class)->except(['show', 'destroy']);

        Route::get('/logout', [SystemLogoutController::class, 'logout'])->name('logout');
    });
});
