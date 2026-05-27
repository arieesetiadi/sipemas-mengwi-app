<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\System\DashboardController;

// PORTAL (Masyarakat)
Route::as('portal.')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});

// ---------------------------------

// SYSTEM (Admin/Internal)
Route::prefix('system')->as('system.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
