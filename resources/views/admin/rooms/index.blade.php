@extends('layouts.app')

@section('content')
<div 
    x-data="{ 
        activeTab: 'active',
        showCreateModal: false, 
        showEditModal: false,
        showDetailModal: false, // <-- TAMBAHKAN INI
        editRoom: {},
        detailRoom: {}, // <-- TAMBAHKAN INI
        editFormAction: ''
    }"
    @keydown.escape.window="showCreateModal = false; showEditModal = false"
    class="py-12"
>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Manage Rooms</h3>
                    <button @click="showCreateModal = true" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        + Add Room
                    </button>
                </div>
                
                <div class="border-b border-gray-200 dark:border-gray-700 mt-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'active'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'active', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'active'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Active Rooms <span class="bg-gray-200 dark:bg-gray-600 text-xs font-semibold ml-2 px-2 py-0.5 rounded-full">{{ $activeRooms->count() }}</span>
                        </button>
                        <button @click="activeTab = 'trashed'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === 'trashed', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'trashed'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Inactive Rooms <span class="bg-gray-200 dark:bg-gray-600 text-xs font-semibold ml-2 px-2 py-0.5 rounded-full">{{ $trashedRooms->count() }}</span>
                        </button>
                    </nav>
                </div>

                <div class="overflow-x-auto mt-6">
                    {{-- Tabel untuk Ruangan Aktif --}}
                    <div x-show="activeTab === 'active'" x-cloak>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Price</th>
                                    <th class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($activeRooms as $room)
                                    <tr>
                                        <td class="px-6 py-4"><img src="{{ asset('storage/' . $room->photo_path) }}" alt="{{ $room->name }}" class="h-16 w-16 object-cover rounded"></td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $room->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        {{-- Tombol pemicu modal edit --}}
                                        <button 
        @click="showDetailModal = true; detailRoom = {{ $room->toJson() }}" 
        class="text-green-600 dark:text-green-400 hover:text-green-900">
        Detail
    </button>
                                        <button 
                                            @click="
                                                showEditModal = true; 
                                                editRoom = {{ $room->toJson() }};
                                                editFormAction = '{{ route('admin.rooms.update', $room) }}';
                                            "
                                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900">
                                            Edit
                                        </button>
                                        <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Move this room to trash?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No active rooms found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Tabel untuk Ruangan Tidak Aktif (Trash) --}}
                    <div x-show="activeTab === 'trashed'" x-cloak>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Deleted At</th>
                                    <th class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($trashedRooms as $room)
                                    <tr>
                                        <td class="px-6 py-4"><img src="{{ asset('storage/' . $room->photo_path) }}" alt="{{ $room->name }}" class="h-16 w-16 object-cover rounded opacity-50"></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 line-through">{{ $room->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $room->deleted_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.rooms.restore', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Restore this room?');">
                                                @csrf
                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:underline">Restore</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Trash is empty.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.rooms.create')
    @include('admin.rooms.edit')
    @include('admin.rooms.show', ['detailRoom' => null]) {{-- Pass null initially --}}  
    
</div>
@endsection