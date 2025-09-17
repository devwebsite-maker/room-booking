<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::with('booking.user', 'booking.room')->latest()->get();
        return view('admin.fines.index', compact('fines'));
    }

    public function create()
    {
        $bookings = Booking::where('status', 'confirmed')->with('user')->get();
        return view('admin.fines.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
        ]);

        Fine::create($validated);
        return redirect()->route('admin.fines.index')->with('success', 'Fine created successfully.');
    }

    public function edit(Fine $fine)
    {
        $bookings = Booking::where('status', 'confirmed')->with('user')->get();
        return view('admin.fines.edit', compact('fine', 'bookings'));
    }

    public function update(Request $request, Fine $fine)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255',
            'status' => 'required|in:paid,unpaid',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $updateData = $validated;
        // Hapus key 'payment_proof' dari data utama karena tidak ada kolomnya di DB
        unset($updateData['payment_proof']);

        if ($request->hasFile('payment_proof')) {
            if ($fine->payment_proof_path) {
                Storage::disk('public')->delete($fine->payment_proof_path);
            }
            $path = $request->file('payment_proof')->store('fine_proofs', 'public');
            // Masukkan path ke dalam data yang akan diupdate
            $updateData['payment_proof_path'] = $path;
        }

        $fine->update($updateData);

        return redirect()->route('admin.fines.index')->with('success', 'Fine updated successfully.');
    }

    public function destroy(Fine $fine)
    {
        if ($fine->payment_proof_path) {
            Storage::disk('public')->delete($fine->payment_proof_path);
        }
        $fine->delete();
        return redirect()->route('admin.fines.index')->with('success', 'Fine deleted successfully.');
    }
}