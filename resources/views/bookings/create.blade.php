<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a New Booking') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(Auth::user()->role == 'admin')
                            <div class="mt-4">
                                <label for="user_id">Book for User</label>
                                <select id="user_id" name="user_id" class="block mt-1 w-full" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="mt-4">
                            <label for="room_id">Select Room</label>
                            <select id="room_id" name="room_id" class="block mt-1 w-full" required>
                                <option value="">-- Choose a room --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }} (Rp {{ number_format($room->price, 2) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="start_time">Start Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" class="block mt-1 w-full" required>
                        </div>
                        <div class="mt-4">
                            <label for="end_time">End Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="block mt-1 w-full" required>
                        </div>
                        <div class="mt-4">
                            <label for="payment_proof">Upload Payment Proof</label>
                            <input type="file" id="payment_proof" name="payment_proof" class="block mt-1 w-full" required>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
                                Book Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>