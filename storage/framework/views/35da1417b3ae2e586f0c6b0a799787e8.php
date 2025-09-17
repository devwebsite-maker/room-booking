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
            <?php echo e(__('Create a New Booking')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <?php if($errors->any()): ?>
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong>Whoops! Something went wrong.</strong>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('bookings.store')); ?>" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        
                        
                        
                        <?php if(Auth::user()->role == 'admin'): ?>
                            <div class="mt-4">
                                <label for="user_id" class="block font-medium text-sm text-gray-700">Book for User</label>
                                <select id="user_id" name="user_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                    <option value="">-- Select a User --</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <label for="room_id">Select Room</label>
                            <select id="room_id" name="room_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="" data-price="0">-- Choose a room --</option>
                                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($room->id); ?>" data-price="<?php echo e($room->price); ?>">
                                        <?php echo e($room->name); ?> (Rp <?php echo e(number_format($room->price, 0, ',', '.')); ?>/day)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="start_time">Check-in Time</label>
                            <input type="datetime-local" id="start_time" name="start_time" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>
                        <div class="mt-4">
                            <label for="end_time">Check-out Time</label>
                            <input type="datetime-local" id="end_time" name="end_time" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mt-6 p-4 bg-gray-100 rounded-lg">
                            <h3 class="font-bold text-lg">Total Price:</h3>
                            <p id="total-price-display" class="text-2xl font-bold text-indigo-600">Rp 0</p>
                        </div>
                        
                        <div class="mt-4">
                            <label for="payment_proof">Upload Payment Proof</label>
                            <input type="file" id="payment_proof" name="payment_proof" class="block mt-1 w-full" required>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border rounded-md font-semibold text-xs text-white uppercase">
                                Book Now
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <?php $__env->startPush('scripts'); ?>
    <script>
        const roomSelect = document.getElementById('room_id');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');
        const priceDisplay = document.getElementById('total-price-display');

        function calculateTotal() {
            const selectedOption = roomSelect.options[roomSelect.selectedIndex];
            const dailyPrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const startTimeValue = startTimeInput.value;
            const endTimeValue = endTimeInput.value;

            if (dailyPrice > 0 && startTimeValue && endTimeValue) {
                const startTime = new Date(startTimeValue);
                const endTime = new Date(endTimeValue);

                if (endTime > startTime) {
                    const timeDifference = endTime.getTime() - startTime.getTime();
                    const days = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));
                    const total = dailyPrice * Math.max(1, days);

                    priceDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    return;
                }
            }
            priceDisplay.textContent = 'Rp 0';
        }

        roomSelect.addEventListener('change', calculateTotal);
        startTimeInput.addEventListener('change', calculateTotal);
        endTimeInput.addEventListener('change', calculateTotal);
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\room-booking\resources\views/bookings/create.blade.php ENDPATH**/ ?>