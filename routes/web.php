<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\DashboardController;

use Illuminate\Http\Request;

// Home route
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Set sidebar state
Route::post('/sidebar-toggle', function (Request $request) {
    $state = $request->input('state', 'expanded');
    return response()->json(['success' => true])
        ->cookie('sidebar_state', $state, 60 * 24 * 30);
});

// Authenticated routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // QR Codes
    Route::resource('qrcodes', QrCodeController::class)->except(['show']);
    Route::get('/qrcodes/{qrcode}/download/{format}', [QrCodeController::class, 'download'])
    ->where('format', 'svg|png')
    ->name('qrcodes.download');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    // Logout
    Route::post('/logout', LogoutController::class)->name('logout');
});

// Public routes
Route::get('/qrcodes/{uuid}', [QrCodeController::class, 'show'])->name('qrcodes.show');

// Guest routes
Route::middleware('guest')->group(function () {
    // Login
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', LoginController::class)->middleware('throttle:5,1')->name('login.attempt');
});
