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
        
        // ==========================================================
        // PERBAIKAN: Ambil juga data booking untuk dikirim ke modal
        // ==========================================================
        $bookings = Booking::where('status', 'confirmed')
                             ->with(['user', 'room'])
                             ->latest()
                             ->get();

        // Kirim kedua variabel ($fines dan $bookings) ke view
        return view('admin.fines.index', compact('fines', 'bookings'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Update the specified resource in storage.
     */
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
        unset($updateData['payment_proof']);

        if ($request->hasFile('payment_proof')) {
            if ($fine->payment_proof_path) {
                Storage::disk('public')->delete($fine->payment_proof_path);
            }
            $path = $request->file('payment_proof')->store('fine_proofs', 'public');
            $updateData['payment_proof_path'] = $path;
        }

        $fine->update($updateData);

        return redirect()->route('admin.fines.index')->with('success', 'Fine updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fine $fine)
    {
        if ($fine->payment_proof_path) {
            Storage::disk('public')->delete($fine->payment_proof_path);
        }
        $fine->delete();
        return redirect()->route('admin.fines.index')->with('success', 'Fine deleted successfully.');
    }

}