{{-- resources/views/bookings/edit.blade.php --}}
{{-- CATATAN: File ini sekarang adalah partial, bukan halaman penuh --}}

<form method="POST" action="{{ route('bookings.update', $booking) }}" class="space-y-6">
    @csrf
    @method('PUT')

    <div>
        <label for="edit_room_id" class="block font-semibold text-sm text-slate-600 mb-2">Pilih Kamar</label>
        <select id="edit_room_id" name="room_id" class="w-full p-3 bg-slate-100 border-2 border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
            <option value="">-- Pilih salah satu kamar --</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" @if($room->id == $booking->room_id) selected @endif>
                    {{ $room->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="edit_start_time" class="block font-semibold text-sm text-slate-600 mb-2">Waktu Check-in</label>
            <input type="datetime-local" id="edit_start_time" name="start_time" value="{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i') }}" class="w-full p-3 bg-slate-100 border-2 border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
        </div>
        <div>
            <label for="edit_end_time" class="block font-semibold text-sm text-slate-600 mb-2">Waktu Check-out</label>
            <input type="datetime-local" id="edit_end_time" name="end_time" value="{{ \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i') }}" class="w-full p-3 bg-slate-100 border-2 border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
        </div>
    </div>

    <div class="pt-4 flex items-center justify-end gap-4">
        <button type="button" @click="isEditModalOpen = false" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Batal</button>
        <button type="submit" class="bg-slate-800 text-white font-bold py-2 px-6 rounded-lg hover:bg-slate-900 transition-colors">
            Perbarui Pesanan
        </button>
    </div>
</form>