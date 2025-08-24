<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

// Halaman utama
Route::get('/', function () { return view('welcome'); });

// Dashboard
Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

// Rute yang butuh login
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking untuk User & Admin
    Route::resource('bookings', BookingController::class)->except(['show']);
});

// Rute khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // CRUD User
    Route::resource('users', UserController::class);

    // CRUD Ruangan
    Route::resource('rooms', RoomController::class)->except(['show']);

    // Verifikasi Booking
    Route::get('/bookings/{booking}/verify', [BookingController::class, 'verifyView'])->name('bookings.verify.view');
    Route::post('/bookings/{booking}/verify', [BookingController::class, 'verifyAction'])->name('bookings.verify.action');
});

require __DIR__.'/auth.php';