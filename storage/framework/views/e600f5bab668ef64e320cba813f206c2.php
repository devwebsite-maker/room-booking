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
            Edit Fine for Booking #<?php echo e($fine->booking_id); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="<?php echo e(route('admin.fines.index')); ?>" class="text-indigo-600 hover:underline mb-6 inline-block">&larr; Back to Fines List</a>
                    <form method="POST" action="<?php echo e(route('admin.fines.update', $fine)); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div>
                            <label for="booking_id">Related Booking</label>
                            <select name="booking_id" id="booking_id" class="block mt-1 w-full" required>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($booking->id); ?>" <?php if($fine->booking_id == $booking->id): ?> selected <?php endif; ?>>
                                    Booking #<?php echo e($booking->id); ?> by <?php echo e($booking->user->name); ?>

                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="amount">Amount (Rp)</label>
                            <input type="number" name="amount" id="amount" class="block mt-1 w-full" value="<?php echo e($fine->amount); ?>" required>
                        </div>
                        
                        <div class="mt-4">
                            <label for="reason">Reason</label>
                            <textarea name="reason" id="reason" class="block mt-1 w-full" required><?php echo e($fine->reason); ?></textarea>
                        </div>
                        
                        <div class="mt-4">
                            <label for="status">Payment Status</label>
                            <select name="status" id="status" class="block mt-1 w-full">
                                <option value="unpaid" <?php if($fine->status == 'unpaid'): ?> selected <?php endif; ?>>Unpaid</option>
                                <option value="paid" <?php if($fine->status == 'paid'): ?> selected <?php endif; ?>>Paid</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label for="payment_proof">Upload New Payment Proof</label>
                            <input type="file" id="payment_proof" name="payment_proof" class="block mt-1 w-full">
                            <?php if($fine->payment_proof_path): ?>
                                <div class="mt-2">
                                    <p>Current Proof:</p>
                                    <img src="<?php echo e(asset('storage/' . $fine->payment_proof_path)); ?>" alt="Payment Proof" class="max-w-xs h-auto border rounded">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 ...">Update Fine</button>
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
<?php endif; ?><?php /**PATH C:\laragon\www\room-booking\resources\views/admin/fines/edit.blade.php ENDPATH**/ ?>