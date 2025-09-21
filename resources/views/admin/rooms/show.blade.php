<div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="showDetailModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showDetailModal = false"></div>
        <div x-show="showDetailModal" x-transition class="bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-3xl sm:w-full">
            <div class="p-6 md:p-8"><div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div><img :src="'/storage/' + detailRoom.photo_path" :alt="detailRoom.name" class="w-full h-auto object-cover rounded-lg shadow-md"></div>
                <div class="flex flex-col">
                    <h3 class="text-3xl font-bold font-serif text-gray-900 dark:text-gray-100" x-text="detailRoom.name"></h3>
                    <div class="mt-4 text-gray-600 dark:text-gray-300 text-base leading-relaxed"><p x-text="detailRoom.description || 'No description provided.'"></p></div>
                    <div class="mt-auto pt-6"><div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Price per day</p>
                        <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(detailRoom.price)"></p>
                    </div></div>
                </div>
            </div></div>
            <div class="bg-gray-50 dark:bg-gray-900 px-6 py-3 text-right">
                <button type="button" @click="showDetailModal = false" class="btn-secondary">Close</button>
            </div>
        </div>
    </div>
</div>