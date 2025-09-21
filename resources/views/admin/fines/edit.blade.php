<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="showEditModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showEditModal = false"></div>
        <div x-show="showEditModal" x-transition class="bg-white dark:bg-gray-800 rounded-lg shadow-xl transform sm:max-w-lg sm:w-full">
            <form :action="editFormAction" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4" x-text="'Edit Fine for Booking #' + editFine.booking_id"></h3>
                
                <div>
                    <label class="form-label">Related Booking</label>
                    <select name="booking_id" class="input-form" required :value="editFine.booking_id">
                        @foreach($bookings as $booking)
                        <option value="{{ $booking->id }}">Booking #{{ $booking->id }} by {{ $booking->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4"><label class="form-label">Amount (Rp)</label><input type="number" name="amount" :value="editFine.amount" class="input-form" required></div>
                <div class="mt-4"><label class="form-label">Reason</label><textarea name="reason" class="input-form" required x-text="editFine.reason"></textarea></div>
                <div class="mt-4"><label class="form-label">Payment Status</label><select name="status" class="input-form" :value="editFine.status"><option value="unpaid">Unpaid</option><option value="paid">Paid</option></select></div>
                
                <div class="mt-4">
                    <label class="form-label">Upload New Payment Proof</label>
                    <input type="file" name="payment_proof" class="block mt-1 w-full text-gray-500">
                    <div class="mt-2" x-show="editFine.payment_proof_path"><p class="text-sm text-gray-500">Current Proof:</p><img :src="'/storage/' + editFine.payment_proof_path" alt="Payment Proof" class="max-w-xs h-auto border rounded"></div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="showEditModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Update Fine</button>
                </div>
            </form>
        </div>
    </div>
</div>