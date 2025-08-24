<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="block mt-1 w-full" value="{{ $user->name }}" required>
                        </div>
                        <div class="mt-4">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="block mt-1 w-full" value="{{ $user->email }}" required>
                        </div>
                        <div class="mt-4">
                            <label for="password">New Password (leave blank to keep current)</label>
                            <input type="password" id="password" name="password" class="block mt-1 w-full">
                        </div>
                        <div class="mt-4">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="block mt-1 w-full">
                        </div>
                        <div class="mt-4">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="block mt-1 w-full">
                                <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                            </select>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>