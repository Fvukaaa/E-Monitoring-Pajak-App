<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WajibPajakController;
use App\Http\Controllers\PengawasanController;
use App\Http\Controllers\StatusPengawasanController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginr']);

Route::get('regis', [AuthController::class, 'regis'])->name('regis');
Route::post('regis', [AuthController::class, 'regisr']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('wajib-pajak', WajibPajakController::class)->except(['create', 'show', 'edit']);
    Route::post('/wajib-pajak/{wajib_pajak}/bulan', [WajibPajakController::class, 'storeBulan'])->name('wajib-pajak.store-bulan');

    Route::resource('pengawasan', PengawasanController::class)->only(['index', 'update']);

    Route::resource('status-pengawasan', StatusPengawasanController::class)->only(['index', 'update']);

    Route::get('/logout', function () {
        Auth::logout();
        return redirect('login');
    })->name('logout');
});
