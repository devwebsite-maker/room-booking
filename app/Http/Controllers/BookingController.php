<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua pemesanan (untuk admin) atau pemesanan pengguna.
     */
    public function index(Request $request)
    {
        // Siapkan query dasar dengan relasi untuk efisiensi
        $query = Booking::with(['user', 'room']);

        // Ambil data kamar untuk modal 'create'
        $rooms = Room::orderBy('name')->get();
        $users = collect(); // Inisialisasi koleksi kosong

        if (Auth::user()->role === 'admin') {
            // Admin bisa filter berdasarkan status dan pengguna
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            // Admin juga butuh daftar pengguna untuk filter
            $users = User::where('role', 'user')->orderBy('name')->get();
        } else {
            // Pengguna biasa hanya bisa melihat pesanannya sendiri
            $query->where('user_id', Auth::id());
        }

        $bookings = $query->latest()->get();
        $statuses = ['pending', 'confirmed', 'rejected'];

        return view('bookings.index', compact('bookings', 'rooms', 'users', 'statuses'));
    }

    /**
     * Menyimpan pemesanan baru dari form modal.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => 'required|date|after:start_time',
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Validasi ketersediaan kamar
        $isNotAvailable = Booking::where('room_id', $validated['room_id'])
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
            })
            ->where('status', 'confirmed') // Hanya cek yang sudah dikonfirmasi
            ->exists();

        if ($isNotAvailable) {
            return back()->withErrors(['start_time' => 'Kamar tidak tersedia pada rentang tanggal yang dipilih.'])->withInput();
        }

        // Hitung total harga
        $room = Room::findOrFail($validated['room_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $days = $startTime->diffInDays($endTime) + 1; // Termasuk hari check-in
        $totalPrice = $room->price * $days;

        // Simpan bukti pembayaran
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $validated['room_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'payment_proof_path' => $path,
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dibuat & menunggu verifikasi.');
    }

    /**
     * Menampilkan form edit di dalam modal.
     * Method ini ditambahkan untuk melengkapi alur kerja.
     */
    public function edit(Booking $booking)
    {
        // Pastikan pengguna punya izin untuk mengedit (opsional, tergantung kebijakan Anda)
        $this->authorize('update', $booking);
        
        $rooms = Room::orderBy('name')->get();
        // Return partial view untuk dimuat di modal
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    /**
     * Memperbarui pemesanan dari form modal edit.
     * Method ini ditambahkan untuk melengkapi alur kerja.
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
        
        // Validasi ketersediaan kamar (tidak termasuk booking saat ini)
        $isNotAvailable = Booking::where('id', '!=', $booking->id)
            ->where('room_id', $validated['room_id'])
            ->where(function ($query) use ($validated) {
                $query->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
            })
            ->where('status', 'confirmed')
            ->exists();

        if ($isNotAvailable) {
            return back()->withErrors(['start_time' => 'Kamar tidak tersedia pada rentang tanggal yang dipilih.'])->withInput();
        }
        
        // Hitung ulang total harga jika ada perubahan
        $room = Room::findOrFail($validated['room_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $days = $startTime->diffInDays($endTime) + 1;
        $totalPrice = $room->price * $days;

        $booking->update([
            'room_id' => $validated['room_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'total_price' => $totalPrice,
            // Admin bisa mengubah status menjadi pending lagi setelah diedit
            'status' => Auth::user()->role === 'admin' ? 'pending' : $booking->status,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pemesanan.
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        
        // Hapus file bukti pembayaran dari storage
        if ($booking->payment_proof_path) {
            Storage::disk('public')->delete($booking->payment_proof_path);
        }

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    /**
     * (Admin) Menampilkan halaman verifikasi (jika Anda punya halaman terpisah).
     */
    public function verifyView(Booking $booking)
    {
        $this->authorize('verify', $booking);
        return view('admin.bookings.verify', compact('booking'));
    }

    /**
     * (Admin) Melakukan aksi verifikasi.
     */
    public function verifyAction(Request $request, Booking $booking)
    {
        $this->authorize('verify', $booking);
        $request->validate(['status' => ['required', Rule::in(['confirmed', 'rejected'])]]);
        
        $booking->update(['status' => $request->status]);

        return redirect()->route('bookings.index')->with('success', 'Status pemesanan telah diperbarui.');
    }
}