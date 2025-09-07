<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TariffController;
use App\Http\Controllers\Admin\WorkstationController;
use App\Http\Controllers\Admin\BookingController;

use Illuminate\Support\Facades\Route;

// prefix - для пути в адресной строке, name для названия представления
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Главная страница админ-панели
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Управление пользователями
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'users'])->name('users');
        Route::get('/create', [UserController::class, 'createUser'])->name('users.create');
        Route::post('/', [UserController::class, 'storeUser'])->name('users.store');
        Route::get('/{id}/edit', [UserController::class, 'editUser'])->name('users.edit');
        Route::put('/{id}', [UserController::class, 'updateUser'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'deleteUser'])->name('users.delete');
    });

    // Управление тарифами
    Route::group(['prefix' => 'tariffs'], function () {
        Route::get('/', [TariffController::class, 'tariffs'])->name('tariffs');
        Route::get('/create', [TariffController::class, 'createTariff'])->name('tariffs.create');
        Route::post('/', [TariffController::class, 'storeTariff'])->name('tariffs.store');
        Route::get('/{id}/edit', [TariffController::class, 'editTariff'])->name('tariffs.edit');
        Route::put('/{id}', [TariffController::class, 'updateTariff'])->name('tariffs.update');
        Route::delete('/{id}', [TariffController::class, 'deleteTariff'])->name('tariffs.delete');
    });

    // Управление рабочими местами
    Route::group(['prefix' => 'workstations'], function () {
        Route::get('/', [WorkstationController::class, 'workstations'])->name('workstations');
        Route::get('/create', [WorkstationController::class, 'createWorkstation'])->name('workstations.create');
        Route::post('/', [WorkstationController::class, 'storeWorkstation'])->name('workstations.store');
        Route::get('/{id}/edit', [WorkstationController::class, 'editWorkstation'])->name('workstations.edit');
        Route::put('/{id}', [WorkstationController::class, 'updateWorkstation'])->name('workstations.update');
        Route::delete('/{id}', [WorkstationController::class, 'deleteWorkstation'])->name('workstations.delete');
    });

    // Управление бронированиями
    Route::group(['prefix' => 'bookings'], function () {
        Route::get('/', [BookingController::class, 'bookings'])->name('bookings');
        Route::get('/create', [BookingController::class, 'createBooking'])->name('bookings.create');
        Route::post('/', [BookingController::class, 'storeBooking'])->name('bookings.store');
        Route::get('/{id}/edit', [BookingController::class, 'editBooking'])->name('bookings.edit');
        Route::put('/{id}', [BookingController::class, 'updateBooking'])->name('bookings.update');
        Route::delete('/{id}', [BookingController::class, 'deleteBooking'])->name('bookings.delete');
    });
});
