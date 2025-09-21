<div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="showCreateModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showCreateModal = false"></div>
        <div x-show="showCreateModal" x-transition class="bg-white dark:bg-gray-800 rounded-lg shadow-xl transform sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('admin.fines.store') }}" class="p-6">
                @csrf
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Add New Fine</h3>
                
                <div>
                    <label class="form-label">Select Booking</label>
                    <select name="booking_id" class="input-form" required>
                        <option value="">-- Choose a confirmed booking --</option>
                        @foreach($bookings as $booking)
                        <option value="{{ $booking->id }}">Booking #{{ $booking->id }} by {{ $booking->user->name }} ({{ $booking->room->name }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4"><label class="form-label">Amount (Rp)</label><input type="number" name="amount" class="input-form" required></div>
                <div class="mt-4"><label class="form-label">Reason</label><textarea name="reason" rows="4" class="input-form" required></textarea></div>
                
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="showCreateModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Save Fine</button>
                </div>
            </form>
        </div>
    </div>
</div>