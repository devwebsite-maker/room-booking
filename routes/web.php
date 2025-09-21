<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FineController; // Pastikan ini di-import
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Fine;
use Carbon\Carbon;

// Halaman utama
Route::get('/', function () { return view('welcome'); });

// Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    $data = [];

    if ($user->role === 'admin') {
        // Logika untuk mengambil data Admin
        $confirmedBookings = Booking::where('status', 'confirmed');
        
        $data['totalRevenue'] = $confirmedBookings->sum('total_price');
        $data['pendingBookingsCount'] = Booking::where('status', 'pending')->count();
        $data['totalUsers'] = User::where('role', 'user')->count();
        $data['totalRooms'] = Room::count();
        $data['recentBookings'] = Booking::where('status', 'pending')->with(['user', 'room'])->latest()->take(5)->get();

        // Data untuk Grafik (7 hari terakhir)
        $bookingsPerDay = Booking::where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count', 'date');

        $labels = [];
        $chartValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('d M');
            $chartValues[] = $bookingsPerDay->get($date, 0);
        }
        $data['chartData'] = [
            'labels' => $labels,
            'data' => $chartValues,
        ];

    } else {
        // Logika untuk mengambil data User
        $userBookings = Booking::where('user_id', $user->id);
        
        $data['upcomingBooking'] = (clone $userBookings)->where('status', 'confirmed')->where('start_time', '>', now())->orderBy('start_time', 'asc')->first();
        $data['activeBookingsCount'] = (clone $userBookings)->whereIn('status', ['pending', 'confirmed'])->count();
        $data['finesCount'] = Fine::whereHas('booking', function($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'unpaid')->count();
        $data['recentUserBookings'] = (clone $userBookings)->with('room')->latest()->take(5)->get();
    }

    return view('dashboard', $data);
})->middleware(['auth', 'verified'])->name('dashboard');

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