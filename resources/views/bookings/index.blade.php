<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ Auth::user()->role == 'admin' ? 'All Bookings' : 'My Booking History' }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(Auth::user()->role == 'admin')
                        <form method="GET" action="{{ route('bookings.index') }}" class="mb-6">
                            <div class="flex space-x-4">
                                <select name="user_id" class="block">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <select name="status" class="block">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" @if(request('status') == $status) selected @endif>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">Filter</button>
                            </div>
                        </form>
                    @endif
                    <a href="{{ route('bookings.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                        + New Booking
                    </a>
                    <table class="min-w-full divide-y divide-gray-200 mt-6">
                        <thead class="bg-gray-50">
                            <tr>
                                @if(Auth::user()->role === 'admin')<th class="px-6 py-3 text-left">User</th>@endif
                                <th class="px-6 py-3 text-left">Room</th>
                                <th class="px-6 py-3 text-left">Time</th>
                                <th class="px-6 py-3 text-left">Status</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($bookings as $booking)
                                <tr>
                                    @if(Auth::user()->role === 'admin')<td class="px-6 py-4">{{ $booking->user->name }}</td>@endif
                                    <td class="px-6 py-4">{{ $booking->room->name }}</td>
                                    <td class="px-6 py-4">{{ $booking->start_time }} to {{ $booking->end_time }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($booking->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                                            @if($booking->status == 'confirmed') bg-green-100 text-green-800 @endif
                                            @if($booking->status == 'rejected') bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(Auth::user()->role == 'admin')
                                            <a href="{{ route('bookings.verify.view', $booking) }}" class="text-indigo-600">Verify</a>
                                        @endif
                                        @if($booking->status == 'pending' && (Auth::user()->role == 'admin' || Auth::id() == $booking->user_id))
                                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600">Cancel</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-4 text-center">No bookings found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>