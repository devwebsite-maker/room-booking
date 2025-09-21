@extends('layouts.app')

@section('content')
{{-- Tambahkan background gradien di sini untuk efek maksimal --}}
<div class="py-12 bg-gradient-to-br from-gray-50 to-indigo-100 dark:from-gray-900 dark:to-slate-800 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        @if (Auth::user()->role === 'admin')
            {{-- ============================================= --}}
            {{-- TAMPILAN UNTUK ADMIN (GLASSMORPHISM) --}}
            {{-- ============================================= --}}
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Admin Dashboard</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Overview of the system activities.</p>
                </div>

                {{-- Kartu Statistik --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Card 1 --}}
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-lg p-6 rounded-xl shadow-lg border border-white/50 dark:border-gray-700/50 flex items-center space-x-4">
                        <div class="bg-indigo-100 dark:bg-indigo-900/50 p-3 rounded-full"><i class="bi bi-cash-coin text-2xl text-indigo-600 dark:text-indigo-300"></i></div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Revenue</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">IDR {{ number_format($totalRevenue ?? 0, 0) }}</p>
                        </div>
                    </div>
                     {{-- Card 2 --}}
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-lg p-6 rounded-xl shadow-lg border border-white/50 dark:border-gray-700/50 flex items-center space-x-4">
                        <div class="bg-yellow-100 dark:bg-yellow-900/50 p-3 rounded-full"><i class="bi bi-clock-history text-2xl text-yellow-600 dark:text-yellow-300"></i></div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pending Bookings</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingBookingsCount ?? 0 }}</p>
                        </div>
                    </div>
                    {{-- Card 3 --}}
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-lg p-6 rounded-xl shadow-lg border border-white/50 dark:border-gray-700/50 flex items-center space-x-4">
                        <div class="bg-green-100 dark:bg-green-900/50 p-3 rounded-full"><i class="bi bi-people-fill text-2xl text-green-600 dark:text-green-300"></i></div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                    {{-- Card 4 --}}
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-lg p-6 rounded-xl shadow-lg border border-white/50 dark:border-gray-700/50 flex items-center space-x-4">
                        <div class="bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full"><i class="bi bi-door-open-fill text-2xl text-blue-600 dark:text-blue-300"></i></div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Rooms</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalRooms ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                {{-- Grafik & Booking Terbaru --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white/60 dark:bg-gray-800/60 backdrop-blur-lg p-6 rounded-xl shadow-lg border border-white/50 dark:border-gray-700/50">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Bookings per Day (Last 7 Days)</h3>
                        <canvas id="bookingsChart"></canvas>
                    </div>
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-lg p-6 rounded-xl shadow-lg border border-white/50 dark:border-gray-700/50">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Recent Pending Bookings</h3>
                        <div class="space-y-4">
                            @forelse($recentBookings ?? [] as $booking)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $booking->user->name }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $booking->room->name }}</p>
                                    </div>
                                    <a href="{{ route('admin.bookings.verify.view', $booking) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Verify</a>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500 text-center py-4">No pending bookings.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- ============================================= --}}
            {{-- TAMPILAN UNTUK USER BIASA (GLASSMORPHISM) --}}
            {{-- ============================================= --}}
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Welcome back, {{ Auth::user()->name }}!</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ready for your next stay? Let's get started.</p>
                </div>

                {{-- ... (Konten user biasa bisa disesuaikan dengan gaya glassmorphism yang sama) ... --}}
            </div>
        @endif
        
    </div>
</div>
@endsection

{{-- Script Chart.js tetap sama --}}
@push('scripts')
@if(Auth::user()->role === 'admin')
    {{-- Script untuk Chart.js (Hanya untuk Admin) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('bookingsChart');
        // Pastikan Anda mengirim $chartData dari controller
        const chartData = @json($chartData ?? []);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: '# of Bookings',
                    data: chartData.data,
                    backgroundColor: 'rgba(79, 70, 229, 0.5)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                }
            }
        });
    </script>
@endif
@endpush