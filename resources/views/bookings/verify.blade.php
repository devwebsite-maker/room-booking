<div 
    x-show="showVerifyModal" 
    x-cloak 
    class="fixed inset-0 z-50 overflow-y-auto" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
>
    <div class="flex items-center justify-center min-h-screen px-4 text-center">
        {{-- Latar belakang gelap --}}
        <div 
            x-show="showVerifyModal" 
            x-transition 
            class="fixed inset-0 bg-gray-500 bg-opacity-75" 
            @click="showVerifyModal = false"
        ></div>

        {{-- Konten Modal --}}
        <div 
            x-show="showVerifyModal" 
            x-transition 
            class="inline-block bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform sm:max-w-4xl sm:w-full"
        >
            <div class="p-6 md:p-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Booking Verification</h3>
                
                {{-- Konten Detail & Bukti Bayar --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Kolom Kiri: Detail Teks --}}
                    <div class="space-y-3 text-gray-700 dark:text-gray-300">
                        <div>
                            <p class="text-sm font-medium text-gray-500">User</p>
                            <p class="text-lg" x-text="verifyBooking.user ? verifyBooking.user.name : '[User Deleted]'"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Room</p>
                            <p class="text-lg" x-text="verifyBooking.room ? verifyBooking.room.name : '[Room Deleted]'"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Booking Time</p>
                            <p class="text-lg" x-text="new Date(verifyBooking.start_time).toLocaleString() + ' to ' + new Date(verifyBooking.end_time).toLocaleString()"></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Price</p>
                            <p class="text-lg font-bold" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(verifyBooking.total_price)"></p>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Bukti Pembayaran --}}
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-2">Payment Proof</p>
                        <a :href="'/storage/' + verifyBooking.payment_proof_path" target="_blank">
                            <img :src="'/storage/' + verifyBooking.payment_proof_path" :alt="'Payment proof for ' + (verifyBooking.user ? verifyBooking.user.name : '')" class="w-full h-auto object-cover rounded-lg shadow-md hover:opacity-80 transition">
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Bagian Aksi (Tombol Accept/Reject) --}}
            <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 flex justify-between items-center">
                <button 
                    type="button" 
                    @click="showVerifyModal = false" 
                    class="btn-secondary"
                >
                    Close
                </button>
                <div class="flex space-x-4">
                    {{-- Tombol Reject --}}
                    <form :action="'/admin/bookings/' + verifyBooking.id + '/verify'" method="POST" onsubmit="return confirm('Are you sure you want to REJECT this booking?');">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Reject
                        </button>
                    </form>

                    {{-- Tombol Accept --}}
                    <form :action="'/admin/bookings/' + verifyBooking.id + '/verify'" method="POST" onsubmit="return confirm('Are you sure you want to ACCEPT this booking?');">
                        @csrf
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-6 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Accept
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>