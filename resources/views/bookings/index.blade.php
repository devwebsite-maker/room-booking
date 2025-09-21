@extends('layouts.app')

@section('content')
<div 
    x-data="{ 
        activeTab: 'active',
        showCreateModal: false, 
        showEditModal: false,       
        showVerifyModal: false, // <-- TAMBAHKAN INI
        editBooking: {},
        verifyBooking: {}, // <-- TAMBAHKAN INI
        editFormAction: '',
        formatDate: function(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2) + 'T' + ('0' + date.getHours()).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2);
        }
    }"
    @keydown.escape.window="showCreateModal = false; showEditModal = false"
    class="py-12"
>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Notifikasi --}}
        @if (session('success')) <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert"><p>{{ session('success') }}</p></div> @endif
        @if ($errors->any()) <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert"><strong>Whoops! Something went wrong.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ Auth::user()->role == 'admin' ? 'All Bookings' : 'My Booking History' }}</h3>
                    <button @click="showCreateModal = true" class="btn-primary">+ New Booking</button>
                </div>
                
                {{-- Navigasi Tab --}}
                <div class="border-b border-gray-200 dark:border-gray-700 mt-6"><nav class="-mb-px flex space-x-8" aria-label="Tabs"><button @click="activeTab = 'active'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'active', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'active'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Active Bookings <span class="badge">{{ $activeBookings->count() }}</span></button><button @click="activeTab = 'trashed'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'trashed', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'trashed'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Canceled Bookings <span class="badge">{{ $trashedBookings->count() }}</span></button></nav></div>

                {{-- Konten Tabel --}}
                <div class="overflow-x-auto mt-6">
                    <div x-show="activeTab === 'active'" x-cloak>
                        @if(Auth::user()->role == 'admin')<form method="GET" action="{{ route('bookings.index') }}" class="my-4 flex space-x-4 items-center"><select name="user_id" class="input-form"><option value="">All Users</option>@foreach($users as $user)<option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->name }}</option>@endforeach</select><select name="status" class="input-form"><option value="">All Statuses</option>@foreach($statuses as $status)<option value="{{ $status }}" @if(request('status') == $status) selected @endif>{{ ucfirst($status) }}</option>@endforeach</select><button type="submit" class="btn-primary">Filter</button></form>@endif
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700"><tr>@if(Auth::user()->role === 'admin')<th class="table-th">User</th>@endif<th class="table-th">Room</th><th class="table-th">Time</th><th class="table-th">Price</th><th class="table-th">Status</th><th class="relative px-6 py-3"></th></tr></thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($activeBookings as $booking)
                                    <tr>
                                        @if(Auth::user()->role === 'admin')<td class="table-td">{{ $booking->user->name ?? '[...]' }}</td>@endif
                                        <td class="table-td">{{ $booking->room->name ?? '[...]' }}</td><td class="table-td text-sm">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</td><td class="table-td">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td><td class="table-td"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }} {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-800' : '' }} {{ $booking->status == 'rejected' ? 'bg-red-100 text-red-800' : '' }}">{{ ucfirst($booking->status) }}</span></td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            @if(Auth::user()->role == 'admin')<button 
            @click="showVerifyModal = true; verifyBooking = {{ $booking->toJson() }}" 
            class="text-gray-600 dark:text-gray-400 hover:underline">
            Verify
        </button><button @click="showEditModal = true; editBooking = {{ $booking->toJson() }}; editFormAction = '{{ route('bookings.update', $booking) }}';" class="text-indigo-600 dark:text-indigo-400 hover:underline ml-4">Edit</button>@endif
                                            @can('delete', $booking)<form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Cancel booking?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 dark:text-red-400 hover:underline">Cancel</button></form>@endcan
                                        </td>
                                    </tr>
                                @empty <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No active bookings found.</td></tr>@endforelse
                            </tbody>
                        </table> 
                    </div>
                    <div x-show="activeTab === 'trashed'" x-cloak>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('bookings.create')
    @include('bookings.edit')
    @include('bookings.verify')
</div>
@endsection

@push('scripts')
<script>
    function initializePriceCalculator(formType) { }
    document.addEventListener('alpine:init', () => { initializePriceCalculator('create'); initializePriceCalculator('edit'); });
</script>
<script>
    function initializePriceCalculator(formType) {
        // Menentukan elemen berdasarkan prefix form ('create' atau 'edit')
        const roomSelect = document.getElementById(formType + '_room_id');
        const startTimeInput = document.getElementById(formType + '_start_time');
        const endTimeInput = document.getElementById(formType + '_end_time');
        const priceDisplay = document.getElementById(formType + '-total-price-display');

        // Pastikan semua elemen ditemukan sebelum melanjutkan
        if (!roomSelect || !startTimeInput || !endTimeInput || !priceDisplay) {
            console.error('One or more form elements could not be found for form type:', formType);
            return;
        }

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
                    // Menghitung durasi dalam hari, pembulatan ke atas
                    const days = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
                    // Minimal sewa adalah 1 hari
                    const total = dailyPrice * Math.max(1, days); 

                    priceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    return;
                }
            }
            // Jika kondisi tidak terpenuhi, reset harga
            priceDisplay.textContent = 'Rp 0';
        }

        // Tambahkan event listener ke setiap elemen
        roomSelect.addEventListener('change', calculateTotal);
        startTimeInput.addEventListener('change', calculateTotal);
        endTimeInput.addEventListener('change', calculateTotal);
    }

    // Inisialisasi kalkulator untuk kedua form saat AlpineJS siap
    document.addEventListener('alpine:init', () => {
        initializePriceCalculator('create');
        initializePriceCalculator('edit');
    });
</script>
@endpush