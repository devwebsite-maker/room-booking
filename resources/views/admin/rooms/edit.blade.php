<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('rooms.update', $room) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name">Room Name</label>
                            <input type="text" id="name" name="name" class="block mt-1 w-full" value="{{ $room->name }}" required>
                        </div>
                        <div class="mt-4">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="block mt-1 w-full">{{ $room->description }}</textarea>
                        </div>
                        <div class="mt-4">
                            <label for="price">Price per session/hour</label>
                            <input type="number" id="price" name="price" step="0.01" class="block mt-1 w-full" value="{{ $room->price }}" required>
                        </div>
                        <div class="mt-4">
                            <label for="photo">New Room Photo (leave blank to keep current)</label>
                            <input type="file" id="photo" name="photo" class="block mt-1 w-full">
                            <img src="{{ asset('storage/' . $room->photo_path) }}" alt="{{ $room->name }}" class="h-24 w-24 object-cover rounded mt-2">
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update Room
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>