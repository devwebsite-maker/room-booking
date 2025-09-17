<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FineController; // Pastikan ini di-import
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

// Halaman utama
Route::get('/', function () { return view('welcome'); });

// Dashboard
Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

// Rute yang butuh login umum
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('bookings', BookingController::class)->except(['show']);
});

// Rute khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // CRUD User
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::resource('users', UserController::class);

    // CRUD Ruangan
    Route::post('rooms/{room}/restore', [RoomController::class, 'restore'])->name('rooms.restore');
    Route::resource('rooms', RoomController::class)->except(['show']);
    
    // CRUD PENUH UNTUK DENDA (FINES)
    Route::resource('fines', FineController::class);

    // Alur Booking Khusus Admin
    Route::post('bookings/{booking}/restore', [BookingController::class, 'restore'])->name('bookings.restore');
    Route::get('bookings/{booking}/verify', [BookingController::class, 'verifyView'])->name('bookings.verify.view');
    Route::post('bookings/{booking}/verify', [BookingController::class, 'verifyAction'])->name('bookings.verify.action');
});

require __DIR__.'/auth.php';