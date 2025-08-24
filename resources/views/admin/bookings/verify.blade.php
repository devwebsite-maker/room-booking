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
                    <h3 class="text-lg font-bold">Booking Details</h3>
                    <p><strong>User:</strong> {{ $booking->user->name }}</p>
                    <p><strong>Room:</strong> {{ $booking->room->name }}</p>
                    <p><strong>Time:</strong> {{ $booking->start_time }} to {{ $booking->end_time }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                    
                    <h3 class="text-lg font-bold mt-6">Payment Proof</h3>
                    <img src="{{ asset('storage/' . $booking->payment_proof_path) }}" alt="Payment Proof" class="max-w-full h-auto mt-2 border">

                    <form method="POST" action="{{ route('bookings.verify.action', $booking) }}" class="mt-6">
                        @csrf
                        <label for="status">Change Status:</label>
                        <select name="status" id="status" class="block mt-1">
                            <option value="confirmed">Confirm</option>
                            <option value="rejected">Reject</option>
                        </select>
                        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>