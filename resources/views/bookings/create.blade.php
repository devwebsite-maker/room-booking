{{-- resources/views/bookings/create.blade.php --}}
{{-- CATATAN: File ini sekarang adalah partial, bukan halaman penuh --}}

<form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div>
        <label for="create_room_id" class="block font-semibold text-sm text-slate-600 mb-2">Pilih Kamar</label>
        <select id="create_room_id" name="room_id" class="w-full p-3 bg-slate-100 border-2 border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
            <option value="" data-price="0">-- Pilih salah satu kamar --</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                    {{ $room->name }} (Rp {{ number_format($room->price, 0, ',', '.') }}/hari)
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="create_start_time" class="block font-semibold text-sm text-slate-600 mb-2">Waktu Check-in</label>
            <input type="datetime-local" id="create_start_time" name="start_time" class="w-full p-3 bg-slate-100 border-2 border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
        </div>
        <div>
            <label for="create_end_time" class="block font-semibold text-sm text-slate-600 mb-2">Waktu Check-out</label>
            <input type="datetime-local" id="create_end_time" name="end_time" class="w-full p-3 bg-slate-100 border-2 border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 transition" required>
        </div>
    </div>

    <div class="p-4 bg-teal-50 rounded-lg">
        <h3 class="font-bold text-lg text-slate-800">Estimasi Total Harga:</h3>
        <p id="total-price-display" class="text-2xl font-bold text-teal-600">Rp 0</p>
        <p class="text-xs text-slate-500 mt-1">Harga final akan dikonfirmasi oleh admin.</p>
    </div>
    
    <div>
        <label for="payment_proof" class="block font-semibold text-sm text-slate-600 mb-2">Unggah Bukti Pembayaran</label>
        <input type="file" id="payment_proof" name="payment_proof" class="block w-full text-sm text-slate-500
            file:mr-4 file:py-2 file:px-4
            file:rounded-full file:border-0
            file:text-sm file:font-semibold
            file:bg-teal-50 file:text-teal-700
            hover:file:bg-teal-100" required>
    </div>

    <div class="pt-4 flex items-center justify-end gap-4">
        <button type="button" @click="isCreateModalOpen = false" class="text-sm font-semibold text-slate-600 hover:text-slate-800">Batal</button>
        <button type="submit" class="bg-teal-500 text-white font-bold py-2 px-6 rounded-lg hover:bg-teal-600 transition-colors">
            Pesan Sekarang
        </button>
    </div>
</form>