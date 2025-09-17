<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Fine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.fines.index') }}" class="text-indigo-600 hover:underline mb-6 inline-block">&larr; Back to Fines List</a>
                    <form method="POST" action="{{ route('admin.fines.store') }}">
                        @csrf

                        {{-- Dropdown untuk memilih booking --}}
                        <div>
                            <label for="booking_id" class="block font-medium text-sm text-gray-700">Select Booking</label>
                            <select name="booking_id" id="booking_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Choose a confirmed booking --</option>
                                @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}">
                                    Booking #{{ $booking->id }} by {{ $booking->user->name }} ({{ $booking->room->name }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Input untuk jumlah denda --}}
                        <div class="mt-4">
                            <label for="amount" class="block font-medium text-sm text-gray-700">Amount (Rp)</label>
                            <input type="number" name="amount" id="amount" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        {{-- Input untuk alasan denda --}}
                        <div class="mt-4">
                            <label for="reason" class="block font-medium text-sm text-gray-700">Reason</e-label>
                            <textarea name="reason" id="reason" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                        </div>

                        {{-- Tombol submit --}}
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Save Fine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>