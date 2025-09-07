<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\BookingController;

Route::get('/', [TariffController::class, 'index'])->name('home');

Route::get('/index', [TariffController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    // Бронирование
    Route::get('/booking/{tariff}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{tariff}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

    // Личный кабинет
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/Admin/admin.php';