<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::latest()->get();
        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.nyimpan data(create)
     */
    public function store(Request $request)
    {
        // Validasi semua input dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses file upload dan simpan path-nya
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('room_photos', 'public');
            // Tambahkan path ke data yang akan disimpan, tapi di kolom 'photo_path'
            $validatedData['photo_path'] = $path;
        }

        // Hapus key 'photo' dari array karena tidak ada kolomnya di database
        unset($validatedData['photo']);

        // Buat record baru di database HANYA dengan data yang relevan,menampilkan formc
        Room::create($validatedData);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     * ( tidak menggunakan halaman detail, jadi bisa dikosongkan atau redirect),show untuk detail spesifik harus tunggal
     */

    public function show(Room $room)
    {
        return redirect()->route('rooms.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.nyimpan dt jg
     */
    public function update(Request $request, Room $room)
    {
        // Validasi semua input dari form
        $validatedData = $request->validate([
            'name' => 'required|string|max:25Selesai! Dengan mengganti seluruh isi file `RoomController.php` dengan kode di atas, masalah Anda saat menambahkan dan mengedit ruangan akan teratasi.255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // nullable karena foto tidak wajib diubah
        ]);

        // Jika ada file foto baru yang di-upload
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($room->photo_path) {
                Storage::disk('public')->delete($room->photo_path);
            }
            // Simpan foto baru dan dapatkan path-nya
            $path = $request->file('photo')->store('room_photos', 'public');
            // Tambahkan path ke data yang akan di-update
            $validatedData['photo_path'] = $path;
        }

        // Hapus key 'photo' dari array sebelum update
        unset($validatedData['photo']);

        // Update record di database
        $room->update($validatedData);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        // Hapus foto dari storage sebelum menghapus record dari database
        if ($room->photo_path) {
            Storage::disk('public')->delete($room->photo_path);
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}