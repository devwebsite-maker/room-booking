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
            <?php echo e(__('Verify Booking')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="<?php echo e(route('bookings.index')); ?>" class="text-indigo-600 hover:underline">&larr; Back to All Bookings</a>
                    </div>
                    
                    <h3 class="text-lg font-bold">Booking Details</h3>
                    <div class="mt-4 space-y-2">
                        <p><strong>User:</strong> <?php echo e($booking->user->name ?? '[User Deleted]'); ?></p>
                        <p><strong>Room:</strong> <?php echo e($booking->room->name ?? '[Room Deleted]'); ?></p>
                        <p><strong>Time:</strong> <?php echo e(\Carbon\Carbon::parse($booking->start_time)->format('d M Y, H:i')); ?> to <?php echo e(\Carbon\Carbon::parse($booking->end_time)->format('d M Y, H:i')); ?></p>
                        <p><strong>Total Price:</strong> Rp <?php echo e(number_format($booking->total_price, 0, ',', '.')); ?></p>
                        <p><strong>Status:</strong> <?php echo e(ucfirst($booking->status)); ?></p>
                    </div>
                    
                    <h3 class="text-lg font-bold mt-6">Payment Proof</h3>
                    <div class="mt-2 border rounded-md p-2 inline-block">
                        <img src="<?php echo e(asset('storage/' . $booking->payment_proof_path)); ?>" alt="Payment Proof" class="max-w-lg h-auto">
                    </div>

                    <form method="POST" action="<?php echo e(route('admin.bookings.verify.action', $booking)); ?>" class="mt-6">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label for="status" class="block font-medium text-sm text-gray-700">Change Status:</label>
                            <select name="status" id="status" class="block mt-1 rounded-md border-gray-300 shadow-sm">
                                <option value="confirmed">Confirm</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                            Update Status
                        </button>
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
<?php endif; ?><?php /**PATH C:\laragon\www\room-booking\resources\views/admin/bookings/verify.blade.php ENDPATH**/ ?>