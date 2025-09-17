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
                    {{-- Tampilkan error validasi jika ada --}}
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

                    <form method="POST" action="{{ route('bookings.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- =============================================== --}}
                        {{-- BAGIAN BARU: Dropdown User HANYA untuk Admin --}}
                        {{-- =============================================== --}}
                        @if(Auth::user()->role == 'admin')
                            <div class="mt-4">
                                <label for="user_id" class="block font-medium text-sm text-gray-700">Book for User</label>
                                <select id="user_id" name="user_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">-- Select a User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        
                        <div class="mt-4">
                            <label for="room_id">Select Room</label>
                            <select id="room_id" name="room_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="" data-price="0">-- Choose a room --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" data-price="{{ $room->price }}">
                                        {{ $room->name }} (Rp {{ number_format($room->price, 0, ',', '.') }}/day)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="start_time">Check-in Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="end_time">Check-out Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                            <h3 class="font-bold text-lg">Total Price:</h3>
                            <p id="total-price-display" class="text-2xl font-bold text-indigo-600">Rp 0</p>
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
    
    @push('scripts')
    <script>
        const roomSelect = document.getElementById('room_id');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const priceDisplay = document.getElementById('total-price-display');

        function calculateTotal() {
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const dailyPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const startTimeValue = startTimeInput.value;
            const endTimeValue = endTimeInput.value;

            if (dailyPrice > 0 && startTimeValue && endTimeValue) {
                const startTime = new Date(startTimeValue);
                const endTime = new Date(endTimeValue);

                if (endTime > startTime) {
                    const timeDifference = endTime.getTime() - startTime.getTime();
                    const days = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
                    const total = dailyPrice * Math.max(1, days);

                    priceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    return;
                }
            }
            priceDisplay.textContent = 'Rp 0';
        }

        roomSelect.addEventListener('change', calculateTotal);
        startTimeInput.addEventListener('change', calculateTotal);
        endTimeInput.addEventListener('change', calculateTotal);
    </script>
    @endpush
</x-app-layout>