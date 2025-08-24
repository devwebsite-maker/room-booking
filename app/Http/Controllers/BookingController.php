<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon; 

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'room']);

        if (Auth::user()->role === 'admin') {
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
            $users = User::where('role', 'user')->get();
        } else {
            $query->where('user_id', Auth::id());
            $users = collect(); // Kosongkan untuk user biasa
        }

        $bookings = $query->latest()->get();
        return view('bookings.index', [
            'bookings' => $bookings,
            'users' => $users,
            'statuses' => ['pending', 'confirmed', 'rejected']
        ]);
    }

    public function create()
    {
        $rooms = Room::all();
        $users = (Auth::user()->role === 'admin') ? User::where('role', 'user')->get() : collect();
        return view('bookings.create', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $isAdmin = Auth::user()->role === 'admin';

        // --- AWAL PERUBAHAN ---
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'user_id' => $isAdmin ? 'required|exists:users,id' : 'nullable',
            'start_time' => 'required|date|after_or_equal:now',
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                // Logika custom untuk validasi durasi minimal 24 jam
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
        // --- AKHIR PERUBAHAN ---

        if (Booking::where('room_id', $validated['room_id'])->where(fn($q) => $q->where('start_time', '<', $validated['end_time'])->where('end_time', '>', $validated['start_time']))->exists()) {
            throw ValidationException::withMessages(['start_time' => 'The selected time slot is not available.']);
        }

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        Booking::create([
            'user_id' => $isAdmin ? $validated['user_id'] : Auth::id(),
            'room_id' => $validated['room_id'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'payment_proof_path' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully and is now pending for verification.');
    }

    public function verifyView(Booking $booking)
    {
        return view('admin.bookings.verify', compact('booking'));
    }

    public function verifyAction(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:confirmed,rejected']);
        $booking->update(['status' => $request->status]);
        return redirect()->route('bookings.index')->with('success', 'Booking status has been updated.');
    }
    
    // Kita biarkan fungsi edit dan destroy, dengan asumsi alur edit mungkin diperlukan nanti
    public function edit(Booking $booking)
    {
        if (Auth::user()->cannot('update', $booking)) { abort(403); }
        $rooms = Room::all();
        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        if (Auth::user()->cannot('update', $booking)) { abort(403); }

        // --- AWAL PERUBAHAN ---
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'start_time' => 'required|date',
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                // Logika custom untuk validasi durasi minimal 24 jam
                function ($attribute, $value, $fail) use ($request) {
                    $startTime = Carbon::parse($request->input('start_time'));
                    $endTime = Carbon::parse($value);

                    if ($startTime->diffInHours($endTime) < 24) {
                        $fail('The minimum booking duration is 24 hours.');
                    }
                },
            ],
        ]);
        // --- AKHIR PERUBAHAN ---

        if (Booking::where('room_id', $validated['room_id'])->where('id', '!=', $booking->id)->where(fn($q) => $q->where('start_time', '<', $validated['end_time'])->where('end_time', '>', $validated['start_time']))->exists()) {
            throw ValidationException::withMessages(['start_time' => 'The selected time slot is not available.']);
        }

        $booking->update($validated);
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }


    public function destroy(Booking $booking)
    {
        if (Auth::user()->cannot('delete', $booking)) { abort(403); }
        // Sebaiknya, user hanya boleh cancel jika statusnya belum dikonfirmasi
        if ($booking->status !== 'pending' && Auth::user()->role !== 'admin') {
            return redirect()->route('bookings.index')->withErrors('Confirmed booking cannot be canceled.');
        }

        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking canceled successfully.');
    }
}