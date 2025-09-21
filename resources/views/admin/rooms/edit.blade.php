<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="showEditModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showEditModal = false"></div>
        <div x-show="showEditModal" x-transition class="bg-white dark:bg-gray-800 rounded-lg shadow-xl transform sm:max-w-lg sm:w-full">
            <form :action="editFormAction" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf @method('PUT')
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Edit Room</h3>
                <div><label class="form-label">Room Name</label><input type="text" name="name" :value="editRoom.name" class="input-form" required></div>
                <div class="mt-4"><label class="form-label">Description</label><textarea name="description" :value="editRoom.description" class="input-form" rows="4"></textarea></div>
                <div class="mt-4"><label class="form-label">Price per day</label><input type="number" name="price" step="1000" :value="editRoom.price" class="input-form" required></div>
                <div class="mt-4">
                    <label class="form-label">New Photo (leave blank to keep current)</label>
                    <input type="file" name="photo" class="block mt-1 w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <div class="mt-2" x-show="editRoom.photo_path"><img :src="'/storage/' + editRoom.photo_path" :alt="editRoom.name" class="h-24 w-24 object-cover rounded-md"></div>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="showEditModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Update Room</button>
                </div>
            </form>
        </div>
    </div>
</div>