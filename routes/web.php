<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\HomeController;
use App\Http\Controllers\Portal\LoginController;
use App\Http\Controllers\Portal\LogoutController;
use App\Http\Controllers\Portal\PengajuanSuratController;
use App\Http\Controllers\Portal\RegisterController;
use App\Http\Controllers\System\AdminController;
use App\Http\Controllers\System\DashboardController;
use App\Http\Controllers\System\LoginController as SystemLoginController;
use App\Http\Controllers\System\LogoutController as SystemLogoutController;
use App\Http\Controllers\System\PendudukController;
use App\Http\Controllers\System\PengajuanSuratController as SystemPengajuanSuratController;
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

        Route::get('/pengajuan/{jenisSurat}/create', [PengajuanSuratController::class, 'create'])->name('pengajuan.create');
        Route::post('/pengajuan/{jenisSurat}', [PengajuanSuratController::class, 'store'])->name('pengajuan.store');

        Route::get('/pengajuan/{pengajuan}/edit', [PengajuanSuratController::class, 'edit'])->name('pengajuan.edit');
        Route::patch('/pengajuan/{pengajuan}', [PengajuanSuratController::class, 'update'])->name('pengajuan.update');

        Route::get('/pengajuan/{pengajuan}/download', [PengajuanSuratController::class, 'download'])->name('pengajuan.download');
        Route::get('/pengajuan/{pengajuan}/lampiran/{lampiran}', [PengajuanSuratController::class, 'lampiran'])->name('pengajuan.lampiran');

        Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
    });
});

// ---------------------------------

// SYSTEM (Admin/Internal)
Route::prefix('admin')->as('system.')->middleware(MainHandler::class)->group(function () {
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

        Route::get('/pengajuan', [SystemPengajuanSuratController::class, 'index'])->name('pengajuan.index');
        Route::get('/pengajuan/{pengajuan}', [SystemPengajuanSuratController::class, 'show'])->name('pengajuan.show');
        Route::patch('/pengajuan/{pengajuan}/verifikasi', [SystemPengajuanSuratController::class, 'verifikasi'])->name('pengajuan.verifikasi');
        Route::patch('/pengajuan/{pengajuan}/selesai', [SystemPengajuanSuratController::class, 'selesai'])->name('pengajuan.selesai');
        Route::patch('/pengajuan/{pengajuan}/tolak', [SystemPengajuanSuratController::class, 'tolak'])->name('pengajuan.tolak');
        Route::get('/pengajuan/{pengajuan}/lampiran/{lampiran}', [SystemPengajuanSuratController::class, 'lampiran'])->name('pengajuan.lampiran');

        Route::get('/logout', [SystemLogoutController::class, 'logout'])->name('logout');
    });
});
