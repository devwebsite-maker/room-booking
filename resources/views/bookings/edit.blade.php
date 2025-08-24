<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Whoops! Something went wrong.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('bookings.update', $booking) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="room_id" class="block font-medium text-sm text-gray-700">Select Room</label>
                            <select id="room_id" name="room_id" class="block mt-1 w-full" required>
                                <option value="">-- Choose a room --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" @if($room->id == $booking->room_id) selected @endif>
                                        {{ $room->name }} (Capacity: {{ $room->capacity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="start_time" class="block font-medium text-sm text-gray-700">Start Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" value="{{ \Carbon\Carbon::parse($booking->start_time)->format('Y-m-d\TH:i') }}" class="block mt-1 w-full" required>
                        </div>
                        <div class="mt-4">
                            <label for="end_time" class="block font-medium text-sm text-gray-700">End Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" value="{{ \Carbon\Carbon::parse($booking->end_time)->format('Y-m-d\TH:i') }}" class="block mt-1 w-full" required>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>