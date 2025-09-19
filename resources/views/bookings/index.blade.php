@extends('layouts.app')

@section('title', Auth::user()->role == 'admin' ? 'Semua Pemesanan' : 'Riwayat Pemesanan Saya')

@section('content')
<div class="bg-slate-50" x-data="{ isCreateModalOpen: false, isEditModalOpen: false, editBookingUrl: '' }">
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                {{ Auth::user()->role == 'admin' ? 'Manajemen Pemesanan' : 'Riwayat Pemesanan Saya' }}
            </h1>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 p-6 bg-white border border-slate-200 rounded-xl">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    {{-- Bagian filter tetap sama --}}
                    
                    <button @click="isCreateModalOpen = true" class="bg-teal-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-teal-600 transition-colors">
                        + Buat Pesanan Baru
                    </button>
                </div>
            </div>

            <div class="space-y-6">
                @forelse ($bookings as $booking)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="p-6 flex flex-col md:flex-row gap-6">
                            <div class="flex-grow">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold text-slate-800">{{ $booking->room->name }}</h3>
                                    {{-- Status Pill --}}
                                </div>
                                {{-- Info lain... --}}
                            </div>
                            <div class="flex-shrink-0 flex md:flex-col items-center justify-end gap-4">
                                @if(Auth::user()->role == 'admin' || Auth::id() == $booking->user_id)
                                <button @click="isEditModalOpen = true; editBookingUrl = '{{ route('bookings.edit', $booking) }}';" 
                                        class="text-sm font-semibold text-slate-600 hover:text-slate-900">
                                    Edit
                                </button>
                                @endif
                                {{-- Tombol verifikasi dan hapus tetap sama --}}
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Pesan kosong tetap sama --}}
                @endforelse
            </div>
        </div>
    </div>

    {{-- =============================================== --}}
    {{-- MODAL AREA --}}
    {{-- =============================================== --}}

    <div x-show="isCreateModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div @click.away="isCreateModalOpen = false" class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 p-8 transform transition-all" x-show="isCreateModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Buat Pesanan Baru</h2>
            @include('bookings.create')
        </div>
    </div>

    <div x-show="isEditModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div @click.away="isEditModalOpen = false" class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 p-8 transform transition-all" x-show="isEditModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <h2 class="text-2xl font-bold text-slate-800 mb-6">Edit Pesanan</h2>
            {{-- Konten form edit akan dimuat di sini secara dinamis jika diperlukan, atau bisa include partial --}}
            {{-- Untuk simplisitas, kita bisa asumsikan partial 'edit' dimuat dengan data yang sesuai --}}
            {{-- Jika Anda butuh memuat konten dinamis via AJAX, Anda bisa menggunakan fetch API --}}
            <div x-html="editBookingUrl ? fetch(editBookingUrl).then(response => response.text()) : ''">
                {{-- Placeholder saat loading --}}
                <p>Loading...</p> 
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Pastikan script ini dijalankan setelah DOM dimuat
    document.addEventListener('DOMContentLoaded', function () {
        // Kalkulasi harga untuk modal CREATE
        const createModal = document.querySelector('[x-data]'); // Target elemen Alpine
        const observer = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                if (mutation.type === 'childList') {
                    const roomSelect = document.getElementById('create_room_id');
                    const startTimeInput = document.getElementById('create_start_time');
                    const endTimeInput = document.getElementById('create_end_time');
                    const priceDisplay = document.getElementById('total-price-display');
                    
                    if(roomSelect && startTimeInput && endTimeInput && priceDisplay) {
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
                        // Hentikan observasi setelah event listener ditambahkan
                        observer.disconnect(); 
                    }
                }
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    });
</script>
@endpush