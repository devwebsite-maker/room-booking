@extends('layouts.app')

@section('content')
<div 
    x-data="{ 
        activeTab: 'active',
        showCreateModal: false, 
        showEditModal: false,
        editUser: {},
        editFormAction: ''
    }"
    @keydown.escape.window="showCreateModal = false; showEditModal = false"
    class="py-12"
>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('success'))<div class="alert-success mb-4">{{ session('success') }}</div>@endif
        @if ($errors->any())<div class="alert-danger mb-4"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">User Management</h3>
                    <button @click="showCreateModal = true" class="btn-primary">+ Add User</button>
                </div>
                
                <div class="border-b border-gray-200 dark:border-gray-700 mt-6">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button @click="activeTab = 'active'" :class="{'tab-active': activeTab === 'active', 'tab-inactive': activeTab !== 'active'}" class="tab-button">Active Users <span class="badge">{{ $activeUsers->count() }}</span></button>
                        <button @click="activeTab = 'trashed'" :class="{'tab-active': activeTab === 'trashed', 'tab-inactive': activeTab !== 'trashed'}" class="tab-button">Inactive Users <span class="badge">{{ $trashedUsers->count() }}</span></button>
                    </nav>
                </div>

                <div class="overflow-x-auto mt-6">
                    <div x-show="activeTab === 'active'" x-cloak>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700"><tr><th class="table-th">Name</th><th class="table-th">Email</th><th class="table-th">Role</th><th class="relative px-6 py-3"></th></tr></thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($activeUsers as $user)
                                    <tr>
                                        <td class="table-td">{{ $user->name }}</td><td class="table-td">{{ $user->email }}</td><td class="table-td">{{ ucfirst($user->role) }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <button @click="showEditModal = true; editUser = {{ $user->toJson() }}; editFormAction = '{{ route('admin.users.update', $user) }}';" class="text-indigo-600 hover:underline">Edit</button>
                                            @if(auth()->id() != $user->id)
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Move this user to trash?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No active users found.</td></tr>@endforelse
                            </tbody>
                        </table>
                    </div>
                    <div x-show="activeTab === 'trashed'" x-cloak>
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700"><tr><th class="table-th">Name</th><th class="table-th">Email</th><th class="table-th">Deleted At</th><th class="relative px-6 py-3"></th></tr></thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($trashedUsers as $user)
                                    <tr>
                                        <td class="table-td"><s>{{ $user->name }}</s></td><td class="table-td"><s>{{ $user->email }}</s></td><td class="table-td">{{ $user->deleted_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="inline">@csrf<button type="submit" class="text-green-600 hover:underline">Restore</button></form>
                                        </td>
                                    </tr>
                                @empty <tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">Trash is empty.</td></tr>@endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.users.create')
    @include('admin.users.edit')
</div>
@endsection