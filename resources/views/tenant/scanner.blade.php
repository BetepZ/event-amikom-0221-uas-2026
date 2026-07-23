<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8V6a2 2 0 012-2h2M3 16v2a2 2 0 002 2h2M21 8V6a2 2 0 00-2-2h-2M21 16v2a2 2 0 01-2 2h-2M9 9h6v6H9z"></path></svg>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Scanner Tiket Penonton') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="ticketScanner()">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 p-6 sm:p-10 relative">
                
                <div x-show="isProcessing" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 z-50 bg-white/80 backdrop-blur-sm flex flex-col justify-center items-center rounded-3xl">
                    <svg class="animate-spin h-12 w-12 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <p class="text-gray-900 font-extrabold text-lg tracking-wide">Memvalidasi tiket...</p>
                </div>

                <!-- Judul Instruksi -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl font-black text-gray-900 tracking-tight">Arahkan QR Code</h3>
                    <p class="text-gray-500 text-sm mt-2 font-medium">Pastikan pencahayaan cukup agar kamera mudah membaca kode.</p>
                </div>

                <!-- Wadah Kamera (Akan diisi oleh library html5-qrcode) -->
                <div class="flex justify-center mb-8">
                    <div class="w-full max-w-sm p-2 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-300">
                        <div id="reader" class="w-full rounded-xl overflow-hidden bg-black aspect-square shadow-inner flex items-center justify-center"></div>
                    </div>
                </div>

                <!-- Opsi Input Manual (Fallback) -->
                <div x-show="!isProcessing && resultMessage === ''" class="max-w-sm mx-auto border-t border-gray-200 pt-8">
                    <label for="manual_code" class="block text-sm font-bold text-gray-700 mb-3 text-center">Kamera bermasalah? Masukkan manual</label>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                            </div>
                            <input type="text" id="manual_code" x-model="manualTicketCode" @keyup.enter="verifyManual()" placeholder="TKT-XXXXXX" class="block w-full pl-10 rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm uppercase font-mono font-bold tracking-widest py-3">
                        </div>
                        <button type="button" @click="verifyManual()" :disabled="manualTicketCode.trim() === ''" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-gray-900 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 disabled:opacity-50 disabled:cursor-not-allowed transition-all">
                            Validasi
                        </button>
                    </div>
                </div>

                <!-- Hasil Scan (Notifikasi) -->
                <div x-show="resultMessage !== ''" style="display: none;"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     :class="{'bg-green-50 border-green-200': isSuccess, 'bg-red-50 border-red-200': !isSuccess}"
                     class="mt-6 p-6 rounded-2xl border text-center shadow-inner">
                    
                    <div class="flex justify-center mb-4">
                        <!-- Icon Sukses -->
                        <div x-show="isSuccess" class="bg-green-100 p-3 rounded-full">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <!-- Icon Gagal -->
                        <div x-show="!isSuccess" class="bg-red-100 p-3 rounded-full">
                            <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </div>
                    </div>
                    
                    <h4 class="text-xl font-black mb-4" :class="{'text-green-800': isSuccess, 'text-red-800': !isSuccess}" x-text="resultMessage"></h4>
                    
                    <!-- Detail Pembeli (Muncul jika ada) -->
                    <div x-show="buyerInfo" class="mt-4 text-sm text-gray-700 bg-white p-4 rounded-xl border border-gray-100/50 shadow-sm text-left inline-block w-full max-w-xs">
                        <div class="space-y-2">
                            <p class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-500 font-medium">Nama</span>
                                <span class="font-bold text-gray-900" x-text="buyerInfo?.buyer_name"></span>
                            </p>
                            <p class="flex justify-between border-b border-gray-100 pb-2">
                                <span class="text-gray-500 font-medium">Tiket</span>
                                <span class="font-bold text-gray-900" x-text="buyerInfo?.ticket_tier"></span>
                            </p>
                            <p class="flex justify-between pt-1">
                                <span class="text-gray-500 font-medium">Event</span>
                                <span class="font-bold text-gray-900 truncate ml-2 max-w-[120px]" x-text="buyerInfo?.event_title" :title="buyerInfo?.event_title"></span>
                            </p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button @click="resetScanner()" class="w-full sm:w-auto px-8 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-xl text-sm font-extrabold hover:bg-gray-50 hover:border-gray-300 focus:ring-4 focus:ring-gray-100 transition-all shadow-sm">
                            Scan Tiket Berikutnya
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Tambahkan Library html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('ticketScanner', () => ({
                html5QrcodeScanner: null,
                isProcessing: false,
                isSuccess: false,
                resultMessage: '',
                buyerInfo: null,
                manualTicketCode: '', // Variabel untuk menampung ketikan manual

                init() {
                    // Konfigurasi Kamera (Kamera Belakang lebih diutamakan, UI disembunyikan bawaannya agar rapi)
                    this.html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", 
                        { fps: 10, qrbox: {width: 250, height: 250}, aspectRatio: 1.0 }, 
                        /* verbose= */ false
                    );
                    
                    this.html5QrcodeScanner.render(this.onScanSuccess.bind(this), this.onScanFailure.bind(this));
                },

                // Fungsi utama untuk menembak ke server (Bisa dipanggil dari kamera atau manual)
                verifyTicket(code) {
                    if (this.isProcessing || this.resultMessage !== '') return;

                    this.isProcessing = true;
                    
                    // Jeda sebentar agar kamera tidak berkedip/langsung mati
                    if(this.html5QrcodeScanner) {
                        try { this.html5QrcodeScanner.pause(true); } catch (e) { console.log(e) }
                    }

                    // Kirim ke server Laravel dengan AJAX (Fetch API)
                    fetch('{{ route('tenant.scanner.verify') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ ticket_code: code })
                    })
                    .then(response => response.json().then(data => ({status: response.status, body: data})))
                    .then(res => {
                        this.isProcessing = false;
                        this.isSuccess = res.body.success;
                        this.resultMessage = res.body.message;
                        this.buyerInfo = res.body.data || null;
                    })
                    .catch(error => {
                        this.isProcessing = false;
                        this.isSuccess = false;
                        this.resultMessage = 'Terjadi kesalahan jaringan saat memvalidasi tiket.';
                        this.buyerInfo = null;
                    });
                },

                onScanSuccess(decodedText, decodedResult) {
                    // Panggil fungsi utama jika terbaca kamera
                    this.verifyTicket(decodedText);
                },

                verifyManual() {
                    // Panggil fungsi utama dari form ketik (pastikan huruf besar semua tanpa spasi)
                    let code = this.manualTicketCode.trim().toUpperCase();
                    if(code !== '') {
                        this.verifyTicket(code);
                    }
                },

                onScanFailure(error) {
                    // Abaikan error saat tidak ada QR di depan kamera (agar tidak spam console/UI)
                },

                resetScanner() {
                    this.isProcessing = false;
                    this.resultMessage = '';
                    this.buyerInfo = null;
                    this.manualTicketCode = ''; // Kosongkan form input
                    
                    // Nyalakan kamera lagi
                    if(this.html5QrcodeScanner) {
                        try { this.html5QrcodeScanner.resume(); } catch (e) { console.log(e) }
                    }
                }
            }));
        });
    </script>
</x-app-layout>