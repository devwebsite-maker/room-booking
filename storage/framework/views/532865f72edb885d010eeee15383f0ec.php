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
            <?php echo e(__('Add New Fine')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="<?php echo e(route('admin.fines.index')); ?>" class="text-indigo-600 hover:underline mb-6 inline-block">&larr; Back to Fines List</a>
                    <form method="POST" action="<?php echo e(route('admin.fines.store')); ?>">
                        <?php echo csrf_field(); ?>

                        
                        <div>
                            <label for="booking_id" class="block font-medium text-sm text-gray-700">Select Booking</label>
                            <select name="booking_id" id="booking_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">-- Choose a confirmed booking --</option>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($booking->id); ?>">
                                    Booking #<?php echo e($booking->id); ?> by <?php echo e($booking->user->name); ?> (<?php echo e($booking->room->name); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        
                        <div class="mt-4">
                            <label for="amount" class="block font-medium text-sm text-gray-700">Amount (Rp)</label>
                            <input type="number" name="amount" id="amount" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        
                        <div class="mt-4">
                            <label for="reason" class="block font-medium text-sm text-gray-700">Reason</e-label>
                            <textarea name="reason" id="reason" rows="4" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                        </div>

                        
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Save Fine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\room-booking\resources\views/admin/fines/create.blade.php ENDPATH**/ ?>