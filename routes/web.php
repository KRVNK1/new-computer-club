<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

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

// prefix - для пути в адресной строке, name для названия представления
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Главная страница админ-панели
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Управление пользователями
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Управление тарифами
    Route::get('/tariffs', [AdminController::class, 'tariffs'])->name('tariffs');
    Route::get('/tariffs/create', [AdminController::class, 'createTariff'])->name('tariffs.create');
    Route::post('/tariffs', [AdminController::class, 'storeTariff'])->name('tariffs.store');
    Route::get('/tariffs/{id}/edit', [AdminController::class, 'editTariff'])->name('tariffs.edit');
    Route::put('/tariffs/{id}', [AdminController::class, 'updateTariff'])->name('tariffs.update');
    Route::delete('/tariffs/{id}', [AdminController::class, 'deleteTariff'])->name('tariffs.delete');

    // Управление рабочими местами
    Route::get('/workstations', [AdminController::class, 'workstations'])->name('workstations');
    Route::get('/workstations/create', [AdminController::class, 'createWorkstation'])->name('workstations.create');
    Route::post('/workstations', [AdminController::class, 'storeWorkstation'])->name('workstations.store');
    Route::get('/workstations/{id}/edit', [AdminController::class, 'editWorkstation'])->name('workstations.edit');
    Route::put('/workstations/{id}', [AdminController::class, 'updateWorkstation'])->name('workstations.update');
    Route::delete('/workstations/{id}', [AdminController::class, 'deleteWorkstation'])->name('workstations.delete');

    // Управление бронированиями
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/create', [AdminController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [AdminController::class, 'storeBooking'])->name('bookings.store');
    Route::get('/bookings/{id}/edit', [AdminController::class, 'editBooking'])->name('bookings.edit');
    Route::put('/bookings/{id}', [AdminController::class, 'updateBooking'])->name('bookings.update');
    Route::delete('/bookings/{id}', [AdminController::class, 'deleteBooking'])->name('bookings.delete');
});

require __DIR__ . '/auth.php';
