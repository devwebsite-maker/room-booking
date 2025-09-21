{{-- Modal untuk menampilkan detail denda --}}
<div 
    x-show="showFineDetailsModal" 
    x-cloak 
    class="fixed inset-0 z-50 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        {{-- Latar belakang gelap --}}
        <div 
            x-show="showFineDetailsModal" 
            x-transition 
            class="fixed inset-0 bg-gray-500 bg-opacity-75" 
            @click="showFineDetailsModal = false"
        ></div>

        {{-- Konten Modal --}}
        <div 
            x-show="showFineDetailsModal" 
            x-transition 
            class="inline-block bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-2xl sm:w-full"
        >
            <div class="p-6 md:p-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Fine Details</h3>
                <p class="text-sm text-gray-500 mb-6" x-text="'For booking: ' + (bookingWithFines.room ? bookingWithFines.room.name : '')"></p>
                
                {{-- Daftar Rincian Denda --}}
                <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
                    <div class="flex text-sm font-medium text-gray-500 border-b dark:border-gray-700 pb-2">
                        <div class="flex-grow">Reason</div>
                        <div class="w-28 text-right">Amount</div>
                        <div class="w-24 text-center">Status</div>
                    </div>
                    <template x-for="fine in bookingWithFines.fines" :key="fine.id">
                        <div class="flex items-center text-sm py-2">
                            <div class="flex-grow text-gray-800 dark:text-gray-200" x-text="fine.reason"></div>
                            <div class="w-28 text-right text-gray-800 dark:text-gray-200 font-mono" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(fine.amount)"></div>
                            <div class="w-24 text-center">
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full"
                                      :class="{
                                        'bg-red-100 text-red-800': fine.status === 'unpaid',
                                        'bg-green-100 text-green-800': fine.status === 'paid'
                                      }"
                                      x-text="fine.status">
                                </span>
                            </div>
                        </div>
                    </template>
                     <div x-show="!bookingWithFines.fines || bookingWithFines.fines.length === 0">
                        <p class="text-center text-gray-500 py-8">🎉 No fines for this booking!</p>
                    </div>
                </div>
            </div>
            
            {{-- Bagian Aksi --}}
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 flex justify-between items-center">
                <div>
                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Unpaid:</span>
                    <span class="text-lg font-bold text-red-600" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(bookingWithFines.fines ? bookingWithFines.fines.filter(f => f.status === 'unpaid').reduce((sum, f) => sum + parseFloat(f.amount), 0) : 0)">
                    </span>
                </div>
                <div class="flex space-x-4">
                    <button type="button" @click="showFineDetailsModal = false" class="btn-secondary">Close</button>
                    {{-- Tombol ini bisa Anda hubungkan ke halaman pembayaran --}}
                    <button type="button" class="btn-primary" x-show="bookingWithFines.fines && bookingWithFines.fines.some(f => f.status === 'unpaid')">Pay Now</button>
                </div>
            </div>
        </div>
    </div>
</div>