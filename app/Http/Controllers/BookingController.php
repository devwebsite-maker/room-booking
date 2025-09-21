<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;
public function index(Request $request)
{
    // ... (kode query yang sudah ada tidak perlu diubah)
    $activeBookingsQuery = Booking::with(['user', 'room']);
    $trashedBookingsQuery = Booking::onlyTrashed()->with(['user', 'room']);
    
    if (Auth::user()->role === 'admin') {
        if ($request->filled('status')) { $activeBookingsQuery->where('status', $request->status); }
        if ($request->filled('user_id')) { $activeBookingsQuery->where('user_id', $request->user_id); }
        $users = User::where('role', 'user')->get();
    } else {
        $activeBookingsQuery->where('user_id', Auth::id());
        $trashedBookingsQuery->where('user_id', Auth::id());
        $users = collect();
    }
    
    $activeBookings = $activeBookingsQuery->latest()->get();
    $trashedBookings = $trashedBookingsQuery->latest()->get();

    // ===============================================
    // TAMBAHKAN BARIS INI
    // ===============================================
    $rooms = Room::all(); // Mengambil semua data kamar

    return view('bookings.index', [
        'activeBookings' => $activeBookings,
        'trashedBookings' => $trashedBookings,
        'users' => $users,
        'statuses' => ['pending', 'confirmed', 'rejected'],
        'rooms' => $rooms, // <-- DAN TAMBAHKAN DI SINI
    ]);
}

    public function create()
    {
        $rooms = Room::all();
        $users = (Auth::user()->role === 'admin') ? User::where('role', 'user')->latest()->get() : collect();
        return view('bookings.create', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $isAdmin = Auth::user()->role === 'admin';
        $validated = $request->validate([
            'user_id' => $isAdmin ? 'required|exists:users,id' : 'nullable',
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => [
                'required', 'date', 'after:start_time',
                function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::parse($request->input('start_time'));
                    $endTime = Carbon::parse($value);
                    if ($startTime->diffInHours($endTime) < 24) {
                        $fail('The minimum booking duration is 24 hours.');
                    }
                },
            ],
            'payment_proof' => 'required|image|max:2048',
        ]);
        
        if (Booking::where('room_id', $validated['room_id'])->where(fn($q) => $q->where('start_time', '<', $validated['end_time'])->where('end_time', '>', $validated['start_time']))->exists()) {
            throw ValidationException::withMessages(['start_time' => 'The selected time slot is not available.']);
        }

        $room = Room::findOrFail($validated['room_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $numberOfDays = max(1, $startTime->diffInDaysFiltered(fn($date) => true, $endTime));
        $totalPrice = $room->price * $numberOfDays;

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        Booking::create([
            'user_id' => $isAdmin ? $validated['user_id'] : Auth::id(),
            'room_id' => $validated['room_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'payment_proof_path' => $path,
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully and is now pending for verification.');
    }
    
    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        $rooms = Room::all();
        $users = (Auth::user()->role === 'admin') ? User::where('role', 'user')->get() : collect();
        return view('bookings.edit', compact('booking', 'rooms', 'users'));
    }
    
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $isAdmin = Auth::user()->role === 'admin';
        $validated = $request->validate([
            'user_id' => $isAdmin ? 'required|exists:users,id' : 'nullable',
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => [
                'required', 'date', 'after:start_time',
                 function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::parse($request->input('start_time'));
                    $endTime = Carbon::parse($value);
                    if ($startTime->diffInHours($endTime) < 24) {
                        $fail('The minimum booking duration is 24 hours.');
                    }
                },
            ],
        ]);

        if (Booking::where('room_id', $validated['room_id'])->where('id', '!=', $booking->id)->where(fn($q) => $q->where('start_time', '<', $validated['end_time'])->where('end_time', '>', $validated['start_time']))->exists()) {
            throw ValidationException::withMessages(['start_time' => 'The selected time slot is not available.']);
        }
        
        $room = Room::findOrFail($validated['room_id']);
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $numberOfDays = max(1, $startTime->diffInDaysFiltered(fn($date) => true, $endTime));
        $validated['total_price'] = $room->price * $numberOfDays;

        $booking->update($validated);
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking moved to trash successfully.');
    }
    
    // --- FUNGSI KHUSUS ADMIN ---
    
    public function verifyView(Booking $booking)
    {
        $this->authorize('viewAny', Booking::class);
        return view('admin.bookings.verify', compact('booking'));
    }

    public function verifyAction(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $request->validate(['status' => 'required|in:confirmed,rejected']);
        $booking->update(['status' => $request->status]);
        return redirect()->route('bookings.index')->with('success', 'Booking status has been updated.');
    }
    
    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $this->authorize('restore', $booking);
        $booking->restore();
        return redirect()->route('bookings.index')->with('success', 'Booking restored successfully.');
    }
}