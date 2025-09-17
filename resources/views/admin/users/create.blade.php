<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div>
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name') }}" required>
                        </div>
                        <div class="mt-4">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" value="{{ old('email') }}" required>
                        </div>
                        <div class="mt-4">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Save User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>