<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Booking</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')
                        @if(Auth::user()->role == 'admin')
                        <div class="mt-4">
                            <label for="user_id" class="block font-medium text-sm text-gray-700">Book for User</label>
                            <select id="user_id" name="user_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" @if($booking->user_id == $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="mt-4">
                            <label for="room_id" class="block font-medium text-sm text-gray-700">Select Room</label>
                            <select id="room_id" name="room_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                 @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $room->price }}" @if($booking->room_id == $room->id) selected @endif>
                                        {{ $room->name }} (Rp {{ number_format($room->price, 0, ',', '.') }}/day)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="start_time" class="block font-medium text-sm text-gray-700">Check-in Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" value="{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="end_time" class="block font-medium text-sm text-gray-700">Check-out Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" value="{{ \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i') }}" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                         <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                            <h3 class="font-bold text-lg">Total Price:</h3>
                            <p id="total-price-display" class="text-2xl font-bold text-indigo-600">Rp 0</p>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">Update Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        // ... (Kode JavaScript kalkulator tidak berubah) ...
    </script>
    @endpush
</x-app-layout>