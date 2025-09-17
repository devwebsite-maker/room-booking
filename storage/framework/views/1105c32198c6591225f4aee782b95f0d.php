<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(Auth::user()->role == 'admin' ? 'All Bookings' : 'My Booking History'); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm-px-6 lg-px-8">
            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm-inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            
            <div class="bg-white overflow-hidden shadow-sm sm-rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Active Bookings</h3>
                    <a href="<?php echo e(route('bookings.create')); ?>" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                        + New Booking
                    </a>
                    
                    <?php if(Auth::user()->role == 'admin'): ?>
                        
                        <form method="GET" action="<?php echo e(route('bookings.index')); ?>" class="my-4 flex space-x-4 items-center">
                            <select name="user_id" class="block rounded-md border-gray-300 shadow-sm">
                                <option value="">All Users</option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($user->id); ?>" <?php if(request('user_id') == $user->id): ?> selected <?php endif; ?>><?php echo e($user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select name="status" class="block rounded-md border-gray-300 shadow-sm">
                                <option value="">All Statuses</option>
                                <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php if(request('status') == $status): ?> selected <?php endif; ?>><?php echo e(ucfirst($status)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">Filter</button>
                        </form>
                    <?php endif; ?>
                    
                    <div class="overflow-x-auto mt-6">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <?php if(Auth::user()->role === 'admin'): ?><th class="px-6 py-3 text-left">User</th><?php endif; ?>
                                    <th class="px-6 py-3 text-left">Room</th>
                                    <th class="px-6 py-3 text-left">Time</th>
                                    <th class="px-6 py-3 text-left">Total Price</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="relative px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__empty_1 = true; $__currentLoopData = $activeBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <?php if(Auth::user()->role === 'admin'): ?>
                                            <td class="px-6 py-4"><?php echo e($booking->user->name ?? '[User Deleted]'); ?></td>
                                        <?php endif; ?>
                                        <td class="px-6 py-4"><?php echo e($booking->room->name ?? '[Room Deleted]'); ?></td>
                                        <td class="px-6 py-4 text-sm"><?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i')); ?></td>
                                        <td class="px-6 py-4">Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?php if($booking->status == 'pending'): ?> bg-yellow-100 text-yellow-800 <?php endif; ?>
                                                <?php if($booking->status == 'confirmed'): ?> bg-green-100 text-green-800 <?php endif; ?>
                                                <?php if($booking->status == 'rejected'): ?> bg-red-100 text-red-800 <?php endif; ?>">
                                                <?php echo e(ucfirst($booking->status)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <?php if($booking->user && $booking->room): ?>
                                                
                                                <?php if(Auth::user()->role == 'admin'): ?>
                                                    <a href="<?php echo e(route('admin.bookings.verify.view', $booking)); ?>" class="text-gray-600 hover:text-gray-900">Verify</a>
                                                    <a href="<?php echo e(route('bookings.edit', $booking)); ?>" class="text-indigo-600 hover:text-indigo-900 ml-4">Edit</a>
                                                <?php endif; ?>
                                                
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $booking)): ?>
                                                <form action="<?php echo e(route('bookings.destroy', $booking)); ?>" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Cancel</button>
                                                </form>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="text-gray-400">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No active bookings found.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            <?php if($trashedBookings->isNotEmpty()): ?>
            <div x-data="{ open: false }" class="mt-8">
                <div class="bg-white overflow-hidden shadow-sm sm-rounded-lg">
                    <div class="p-6 border-b border-gray-200 cursor-pointer" @click="open = !open">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-medium text-gray-900">
                                View Canceled Bookings (Trash)
                                <span class="ml-2 text-sm text-gray-500">(<?php echo e($trashedBookings->count()); ?>)</span>
                            </h3>
                            <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                    <div x-show="open" x-transition class="p-6 text-gray-900 border-t">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <?php if(Auth::user()->role == 'admin'): ?><th class="px-6 py-3 text-left">User</th><?php endif; ?>
                                        <th class="px-6 py-3 text-left">Room</th>
                                        <th class="px-6 py-3 text-left">Canceled At</th>
                                        <?php if(Auth::user()->role == 'admin'): ?><th class="relative px-6 py-3"></th><?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__empty_1 = true; $__currentLoopData = $trashedBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr class="bg-red-50">
                                            <?php if(Auth::user()->role == 'admin'): ?><td class="px-6 py-4"><?php echo e($booking->user->name ?? '[User Deleted]'); ?></td><?php endif; ?>
                                            <td class="px-6 py-4"><?php echo e($booking->room->name ?? '[Room Deleted]'); ?></td>
                                            <td class="px-6 py-4"><?php echo e($booking->deleted_at->format('d M Y')); ?></td>
                                            <?php if(Auth::user()->role == 'admin'): ?>
                                            <td class="px-6 py-4 text-right text-sm font-medium">
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('restore', $booking)): ?>
                                                <form action="<?php echo e(route('admin.bookings.restore', $booking->id)); ?>" method="POST" class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Restore</button>
                                                </form>
                                                <?php endif; ?>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr><td colspan="4" class="py-4 text-center text-gray-500">Trash is empty.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\room-booking\resources\views/bookings/index.blade.php ENDPATH**/ ?>