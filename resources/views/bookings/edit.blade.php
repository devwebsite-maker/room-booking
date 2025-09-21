<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        <div x-show="showEditModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showEditModal = false"></div>
        <div x-show="showEditModal" x-transition class="inline-block bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-lg sm:w-full">
            <form :action="editFormAction" method="POST" class="p-6" id="edit-form">
                @csrf
                @method('PUT')
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100 mb-4">Edit Booking</h3>
                
                @if(Auth::user()->role == 'admin')
                <div class="mt-4">
                    <label for="edit_user_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Book for User</label>
                    <select id="edit_user_id" name="user_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required :value="editBooking.user_id">
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="mt-4"><label for="edit_room_id" class="dark:text-gray-300">Select Room</label><select id="edit_room_id" name="room_id" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required :value="editBooking.room_id">@foreach($rooms as $room)<option value="{{ $room->id }}" data-price="{{ $room->price }}">{{ $room->name }} (Rp {{ number_format($room->price, 0, ',', '.') }}/day)</option>@endforeach</select></div>
                <div class="mt-4"><label for="edit_start_time" class="dark:text-gray-300">Check-in Time</label><input type="datetime-local" id="edit_start_time" name="start_time" :value="formatDate(editBooking.start_time)" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required></div>
                <div class="mt-4"><label for="edit_end_time" class="dark:text-gray-300">Check-out Time</label><input type="datetime-local" id="edit_end_time" name="end_time" :value="formatDate(editBooking.end_time)" class="block mt-1 w-full dark:bg-gray-900 dark:text-gray-300 rounded-md" required></div>
                
                <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg"><h3 class="font-bold text-lg dark:text-gray-200">Total Price:</h3><p id="edit-total-price-display" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">Rp 0</p></div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="showEditModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Update Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>