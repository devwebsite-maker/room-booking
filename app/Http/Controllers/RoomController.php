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
        // Ambil data aktif (yang tidak di-soft-delete)
        $activeRooms = Room::latest()->get();

        // Ambil HANYA data yang ada di "tong sampah"
        $trashedRooms = Room::onlyTrashed()->latest()->get();

        return view('admin.rooms.index', compact('activeRooms', 'trashedRooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('room_photos', 'public');
            $validatedData['photo_path'] = $path;
        }

        unset($validatedData['photo']);
        Room::create($validatedData);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return redirect()->route('admin.rooms.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($room->photo_path) {
                Storage::disk('public')->delete($room->photo_path);
            }
            $path = $request->file('photo')->store('room_photos', 'public');
            $validatedData['photo_path'] = $path;
        }

        unset($validatedData['photo']);
        $room->update($validatedData);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room moved to trash.');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $room = Room::withTrashed()->findOrFail($id);
        $room->restore();
        return redirect()->route('admin.rooms.index')->with('success', 'Room restored successfully.');
    }
}