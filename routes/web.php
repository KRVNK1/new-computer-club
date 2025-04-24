<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;

Route::get('/', [TariffController::class, 'index'])->name('home');

Route::get('/index', [TariffController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/booking/{tariff}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/booking/{tariff}', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [DashboardController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
});

Route::post('/booking/check-availability', [BookingController::class, 'checkAvailability'])
    ->name('booking.check-availability')
    ->middleware('auth');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Главная страница админ-панели
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('index');

    // Управление пользователями
    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [App\Http\Controllers\AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.delete');

    // Управление тарифами
    Route::get('/tariffs', [App\Http\Controllers\AdminController::class, 'tariffs'])->name('tariffs');
    Route::get('/tariffs/create', [App\Http\Controllers\AdminController::class, 'createTariff'])->name('tariffs.create');
    Route::post('/tariffs', [App\Http\Controllers\AdminController::class, 'storeTariff'])->name('tariffs.store');
    Route::get('/tariffs/{id}/edit', [App\Http\Controllers\AdminController::class, 'editTariff'])->name('tariffs.edit');
    Route::put('/tariffs/{id}', [App\Http\Controllers\AdminController::class, 'updateTariff'])->name('tariffs.update');
    Route::delete('/tariffs/{id}', [App\Http\Controllers\AdminController::class, 'deleteTariff'])->name('tariffs.delete');

    // Управление рабочими местами
    Route::get('/workstations', [App\Http\Controllers\AdminController::class, 'workstations'])->name('workstations');
    Route::get('/workstations/create', [App\Http\Controllers\AdminController::class, 'createWorkstation'])->name('workstations.create');
    Route::post('/workstations', [App\Http\Controllers\AdminController::class, 'storeWorkstation'])->name('workstations.store');
    Route::get('/workstations/{id}/edit', [App\Http\Controllers\AdminController::class, 'editWorkstation'])->name('workstations.edit');
    Route::put('/workstations/{id}', [App\Http\Controllers\AdminController::class, 'updateWorkstation'])->name('workstations.update');
    Route::delete('/workstations/{id}', [App\Http\Controllers\AdminController::class, 'deleteWorkstation'])->name('workstations.delete');

    // Управление бронированиями
    Route::get('/bookings', [App\Http\Controllers\AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/create', [App\Http\Controllers\AdminController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/bookings/{id}/edit', [App\Http\Controllers\AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{id}', [App\Http\Controllers\AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::delete('/bookings/{id}', [App\Http\Controllers\AdminController::class, 'deleteBooking'])->name('bookings.delete');
});

require __DIR__ . '/auth.php';
