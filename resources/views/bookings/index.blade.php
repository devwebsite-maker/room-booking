<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role == 'admin' ? 'All Bookings' : 'My Booking History' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm-px-6 lg-px-8">
            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm-inline">{{ session('success') }}</span>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- Tabel Booking Aktif --}}
            <div class="bg-white overflow-hidden shadow-sm sm-rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Active Bookings</h3>
                    <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                        + New Booking
                    </a>
                    
                    @if(Auth::user()->role == 'admin')
                        {{-- Form Filter untuk Admin --}}
                        <form method="GET" action="{{ route('bookings.index') }}" class="my-4 flex space-x-4 items-center">
                            <select name="user_id" class="block rounded-md border-gray-300 shadow-sm">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <select name="status" class="block rounded-md border-gray-300 shadow-sm">
                                <option value="">All Statuses</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" @if(request('status') == $status) selected @endif>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">Filter</button>
                        </form>
                    @endif
                    
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if(Auth::user()->role === 'admin')<th class="px-6 py-3 text-left">User</th>@endif
                                    <th class="px-6 py-3 text-left">Room</th>
                                    <th class="px-6 py-3 text-left">Time</th>
                                    <th class="px-6 py-3 text-left">Total Price</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($activeBookings as $booking)
                                    <tr>
                                        @if(Auth::user()->role === 'admin')
                                            <td class="px-6 py-4">{{ $booking->user->name ?? '[User Deleted]' }}</td>
                                        @endif
                                        <td class="px-6 py-4">{{ $booking->room->name ?? '[Room Deleted]' }}</td>
                                        <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i') }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($booking->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                                @if($booking->status == 'confirmed') bg-green-100 text-green-800 @endif
                                                @if($booking->status == 'rejected') bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            @if($booking->user && $booking->room)
                                                {{-- Tombol hanya untuk Admin --}}
                                                @if(Auth::user()->role == 'admin')
                                                    <a href="{{ route('admin.bookings.verify.view', $booking) }}" class="text-gray-600 hover:text-gray-900">Verify</a>
                                                    <a href="{{ route('bookings.edit', $booking) }}" class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                                @endif
                                                
                                                {{-- Tombol Cancel hanya muncul jika diizinkan oleh Policy --}}
                                                @can('delete', $booking)
                                                <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                                                </form>
                                                @endcan
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No active bookings found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            {{-- Bagian Sampah (Trash) --}}
            @if($trashedBookings->isNotEmpty())
            <div x-data="{ open: false }" class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm-rounded-lg">
                    <div class="p-6 border-b border-gray-200 cursor-pointer" @click="open = !open">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                View Canceled Bookings (Trash)
                                <span class="ml-2 text-sm text-gray-500">({{ $trashedBookings->count() }})</span>
                            </h3>
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <div x-show="open" x-transition class="p-6 text-gray-900 border-t">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @if(Auth::user()->role == 'admin')<th class="px-6 py-3 text-left">User</th>@endif
                                        <th class="px-6 py-3 text-left">Room</th>
                                        <th class="px-6 py-3 text-left">Canceled At</th>
                                        @if(Auth::user()->role == 'admin')<th class="relative px-6 py-3"></th>@endif
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($trashedBookings as $booking)
                                        <tr class="bg-red-50">
                                            @if(Auth::user()->role == 'admin')<td class="px-6 py-4">{{ $booking->user->name ?? '[User Deleted]' }}</td>@endif
                                            <td class="px-6 py-4">{{ $booking->room->name ?? '[Room Deleted]' }}</td>
                                            <td class="px-6 py-4">{{ $booking->deleted_at->format('d M Y') }}</td>
                                            @if(Auth::user()->role == 'admin')
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                @can('restore', $booking)
                                                <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Restore</button>
                                                </form>
                                                @endcan
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="py-4 text-center text-gray-500">Trash is empty.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>