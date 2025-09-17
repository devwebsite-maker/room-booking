<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rooms Trash Bin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('rooms.index') }}" class="text-indigo-600 hover:text-indigo-900 mb-4 inline-block">
                        &larr; Back to Rooms List
                    </a>
                    <table class="min-w-full divide-y divide-gray-200 mt-6">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deleted At</th>
                                <th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td class="px-6 py-4">{{ $room->name }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($room->price, 2) }}</td>
                                    <td class="px-6 py-4">{{ $room->deleted_at }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <form action="{{ route('rooms.restore', $room->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Restore</button>
                                        </form>
                                        <form action="{{ route('rooms.forceDelete', $room->id) }}" method="POST" class="inline ml-4" onsubmit="return confirm('This action is permanent and cannot be undone. Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type-="submit" class="text-red-600 hover:text-red-900">Delete Permanently</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-6 py-4 text-center">Trash is empty.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>