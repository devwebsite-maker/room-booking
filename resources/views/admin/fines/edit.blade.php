<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Fine for Booking #{{ $fine->booking_id }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('admin.fines.index') }}" class="text-indigo-600 hover:underline mb-6 inline-block">&larr; Back to Fines List</a>
                    <form method="POST" action="{{ route('admin.fines.update', $fine) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="booking_id">Related Booking</label>
                            <select name="booking_id" id="booking_id" class="block mt-1 w-full" required>
                                @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" @if($fine->booking_id == $booking->id) selected @endif>
                                    Booking #{{ $booking->id }} by {{ $booking->user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="amount">Amount (Rp)</label>
                            <input type="number" name="amount" id="amount" class="block mt-1 w-full" value="{{ $fine->amount }}" required>
                        </div>
                        
                        <div class="mt-4">
                            <label for="reason">Reason</label>
                            <textarea name="reason" id="reason" class="block mt-1 w-full" required>{{ $fine->reason }}</textarea>
                        </div>
                        
                        <div class="mt-4">
                            <label for="status">Payment Status</label>
                            <select name="status" id="status" class="block mt-1 w-full">
                                <option value="unpaid" @if($fine->status == 'unpaid') selected @endif>Unpaid</option>
                                <option value="paid" @if($fine->status == 'paid') selected @endif>Paid</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="payment_proof">Upload New Payment Proof</label>
                            <input type="file" id="payment_proof" name="payment_proof" class="block mt-1 w-full">
                            @if($fine->payment_proof_path)
                                <div class="mt-2">
                                    <p>Current Proof:</p>
                                    <img src="{{ asset('storage/' . $fine->payment_proof_path) }}" alt="Payment Proof" class="max-w-xs h-auto border rounded">
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 ...">Update Fine</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>