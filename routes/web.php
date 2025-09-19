<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Controller yang akan kita gunakan
use App\Http\Controllers\BookingController; 
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk halaman utama (welcome)
Route::get('/', function () {
    return view('welcome');
});

// Grup untuk semua rute yang memerlukan login
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Rute Dashboard Utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rute Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Pemesanan (bisa diakses semua role yang login)
    Route::resource('bookings', BookingController::class)->except(['show']);


    // ===================================================================
    // GRUP ROUTE KHUSUS ADMIN
    // Semua rute di dalam grup ini hanya bisa diakses oleh admin
    // URL akan diawali dengan /admin (contoh: /admin/rooms)
    // Nama route akan diawali dengan admin. (contoh: admin.rooms.index)
    // ===================================================================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        
        // Rute untuk manajemen kamar
        Route::resource('rooms', RoomController::class);

        // Rute untuk manajemen pengguna
        Route::resource('users', UserController::class);

        // Rute untuk verifikasi pemesanan
        Route::get('bookings/{booking}/verify', [BookingController::class, 'verifyView'])->name('bookings.verify');
        Route::post('bookings/{booking}/verify', [BookingController::class, 'verifyAction']); // Nama tidak wajib jika hanya diakses dari form
    });
});


require __DIR__.'/auth.php';