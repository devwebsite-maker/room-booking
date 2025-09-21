<div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="showEditModal" x-transition class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showEditModal = false"></div>
        <div x-show="showEditModal" x-transition class="bg-white dark:bg-gray-800 rounded-lg shadow-xl transform sm:max-w-lg sm:w-full">
            <form :action="editFormAction" method="POST" class="p-6">
                @csrf
                @method('PUT')
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Edit User</h3>
                <div><label class="form-label">Name</label><input type="text" name="name" :value="editUser.name" class="input-form" required></div>
                <div class="mt-4"><label class="form-label">Email</label><input type="email" name="email" :value="editUser.email" class="input-form" required></div>
                <div class="mt-4"><label class="form-label">New Password (leave blank to keep current)</label><input type="password" name="password" class="input-form"></div>
                <div class="mt-4"><label class="form-label">Confirm New Password</label><input type="password" name="password_confirmation" class="input-form"></div>
                <div class="mt-4"><label class="form-label">Role</label><select name="role" class="input-form" :value="editUser.role"><option value="user">User</option><option value="admin">Admin</option></select></div>
                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" @click="showEditModal = false" class="btn-secondary">Cancel</button>
                    <button type="submit" class="btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>