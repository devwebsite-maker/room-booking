@extends('layouts.app')

@section('content')
<div 
    x-data="{ 
        showCreateModal: false, 
        showEditModal: false,
        editFine: {},
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
                    <h3 class="text-lg font-medium">Fine Management</h3>
                    <button @click="showCreateModal = true" class="btn-primary">+ Add Fine</button>
                </div>
                
                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="table-th">Booking ID</th><th class="table-th">User</th><th class="table-th">Reason</th>
                                <th class="table-th">Amount</th><th class="table-th">Status</th><th class="relative px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($fines as $fine)
                                <tr>
                                    <td class="table-td">#{{ $fine->booking_id }}</td>
                                    <td class="table-td">{{ $fine->booking->user->name ?? 'N/A' }}</td>
                                    <td class="table-td">{{ Str::limit($fine->reason, 40) }}</td>
                                    <td class="table-td">Rp {{ number_format($fine->amount, 0) }}</td>
                                    <td class="table-td"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $fine->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($fine->status) }}</span></td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <button @click="showEditModal = true; editFine = {{ $fine->toJson() }}; editFormAction = '{{ route('admin.fines.update', $fine) }}';" class="text-indigo-600 hover:underline">Edit</button>
                                        <form action="{{ route('admin.fines.destroy', $fine) }}" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure?');">@csrf @method('DELETE')<button type="submit" class="text-red-600 hover:underline">Delete</button></form>
                                    </td>
                                </tr>
                            @empty <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No fines found.</td></tr>@endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.fines.create')
    @include('admin.fines.edit')
</div>
@endsection