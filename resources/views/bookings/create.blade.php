<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div x-show="showCreateModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showCreateModal = false"></div>
        <div x-show="showCreateModal" x-transition class="inline-block bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data" class="p-6" id="create-form">
                @csrf
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100 mb-4">Create a New Booking</h3>
                
                @if(Auth::user()->role == 'admin')
                    <div class="mt-4">
                        <label for="user_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Book for User</label>
                        <select id="user_id" name="user_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mt-4">
                    <label for="create_room_id" class="dark:text-gray-300">Select Room</label>
                    <select id="create_room_id" name="room_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required>
                        <option value="" data-price="0">-- Choose a room --</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                                {{ $room->name }} (Rp {{ number_format($room->price, 0, ',', '.') }}/day)
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4"><label for="create_start_time" class="dark:text-gray-300">Check-in Time</label><input type="datetime-local" id="create_start_time" name="start_time" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required></div>
                <div class="mt-4"><label for="create_end_time" class="dark:text-gray-300">Check-out Time</label><input type="datetime-local" id="create_end_time" name="end_time" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required></div>
                <div class="mt-4"><label for="payment_proof" class="dark:text-gray-300">Upload Payment Proof</label><input type="file" id="payment_proof" name="payment_proof" class="block mt-1 w-full text-gray-500" required></div>
                
                <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg"><h3 class="font-bold text-lg dark:text-gray-200">Total Price:</h3><p id="create-total-price-display" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Rp 0</p></div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="showCreateModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Book Now</button>
                </div>
            </form>
        </div>
    </div>
</div>