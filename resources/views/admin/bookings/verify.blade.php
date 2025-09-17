<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verify Booking') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('bookings.index') }}" class="text-indigo-600 hover:underline">&larr; Back to All Bookings</a>
                    </div>
                    
                    <h3 class="text-lg font-bold">Booking Details</h3>
                    <div class="mt-4 space-y-2">
                        <p><strong>User:</strong> {{ $booking->user->name ?? '[User Deleted]' }}</p>
                        <p><strong>Room:</strong> {{ $booking->room->name ?? '[Room Deleted]' }}</p>
                        <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }} to {{ \Carbon\Carbon::parse($booking->end_time)->format('d M Y, H:i') }}</p>
                        <p><strong>Total Price:</strong> Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                    </div>
                    
                    <h3 class="text-lg font-bold mt-6">Payment Proof</h3>
                    <div class="mt-2 border rounded-md p-2 inline-block">
                        <img src="{{ asset('storage/' . $booking->payment_proof_path) }}" alt="Payment Proof" class="max-w-lg h-auto">
                    </div>

                    <form method="POST" action="{{ route('admin.bookings.verify.action', $booking) }}" class="mt-6">
                        @csrf
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Change Status:</label>
                            <select name="status" id="status" class="block mt-1 rounded-md border-gray-300 shadow-sm">
                                <option value="confirmed">Confirm</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>