<x-app-layout>
    <div class="bg-gray-50 py-12 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Notifikasi Flash -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-3xl border border-gray-100 overflow-hidden">
                <!-- Header Status -->
                <div class="px-6 py-8 border-b border-gray-100 bg-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative overflow-hidden">
                    <!-- Hiasan Background -->
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full blur-2xl opacity-50 pointer-events-none"></div>

                    <div class="relative z-10">
                        <h1 class="text-2xl font-extrabold text-gray-900 flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Detail Pesanan
                        </h1>
                        <p class="text-sm text-gray-500 mt-1 font-medium">Order ID: <span class="font-mono text-blue-700 bg-blue-50 px-2 py-0.5 rounded-md">{{ $order->order_number }}</span></p>
                    </div>
                    
                    <div class="relative z-10">
                        @if($order->status === 'paid')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-extrabold bg-green-50 text-green-700 border border-green-200 shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Lunas / Tiket Terbit
                            </span>
                        @elseif($order->status === 'pending')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-extrabold bg-amber-50 text-amber-700 border border-amber-200 shadow-sm animate-pulse">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menunggu Pembayaran
                            </span>
                        @elseif($order->status === 'expired')
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-extrabold bg-red-50 text-red-700 border border-red-200 shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Waktu Habis (Kedaluwarsa)
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Konten Utama -->
                <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    
                    <!-- Sisi Kiri: Ringkasan Event & Tiket -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Informasi Acara
                            </h3>
                            <div class="flex flex-col sm:flex-row items-start gap-5">
                                @if($order->event->banner_image)
                                    <img src="{{ asset('storage/' . $order->event->banner_image) }}" alt="Banner" class="w-24 h-24 object-cover rounded-2xl shadow-sm shrink-0">
                                @else
                                    <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 shrink-0">
                                        <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h4 class="text-lg font-extrabold text-gray-900 leading-tight mb-2">{{ $order->event->title }}</h4>
                                    <div class="space-y-1.5">
                                        <p class="text-sm font-medium text-gray-600 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ $order->event->event_date->format('l, d F Y') }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-600 flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ Str::limit($order->event->location, 40) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                Rincian Pembayaran
                            </h3>
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 shadow-inner">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-medium text-gray-500">Jenis Tiket</span>
                                    <span class="text-sm font-bold text-gray-900 bg-white px-3 py-1 rounded-md border shadow-sm">{{ $order->ticketTier->name }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-sm font-medium text-gray-500">Jumlah</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $order->quantity }} Orang</span>
                                </div>
                                <div class="border-t-2 border-dashed border-gray-200 mt-4 pt-4 flex justify-between items-center">
                                    <span class="text-base font-bold text-gray-900">Total Harga</span>
                                    <span class="text-2xl font-extrabold text-blue-600">
                                        {{ $order->total_price == 0 ? 'Gratis' : 'Rp ' . number_format($order->total_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sisi Kanan: Action (Bayar / Lihat Tiket) -->
                    <div class="h-full">
                        @if($order->status === 'pending')
                            <!-- Panel Checkout (Belum Lunas) -->
                            <div class="bg-blue-600 rounded-3xl p-8 flex flex-col justify-center items-center text-center h-full relative overflow-hidden shadow-xl">
                                <!-- Efek Dekoratif BG -->
                                <svg class="absolute top-0 right-0 w-32 h-32 text-blue-500 opacity-50 transform translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12"/></svg>
                                <svg class="absolute bottom-0 left-0 w-24 h-24 text-blue-700 opacity-50 transform -translate-x-5 translate-y-5" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="12"/></svg>
                                
                                <div class="relative z-10 w-full" x-data="countdown('{{ $order->expired_at->toIso8601String() }}')" x-init="start()">
                                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 mb-6 border border-white/20">
                                        <p class="text-sm font-bold text-blue-100 uppercase tracking-widest mb-2">Batas Waktu Pembayaran</p>
                                        <div class="text-5xl font-black text-white font-mono tracking-tight drop-shadow-md" x-text="timeDisplay">00:00</div>
                                    </div>
                                    
                                    <button type="button" id="pay-button" class="w-full bg-white text-blue-700 font-extrabold text-lg py-4 px-6 rounded-xl hover:bg-gray-50 hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        Bayar Sekarang
                                    </button>
                                    <p class="text-xs text-blue-200 mt-4 font-medium">Jika waktu habis, pesanan otomatis dibatalkan.</p>
                                </div>
                            </div>

                        @elseif($order->status === 'paid')
                            <!-- Panel Tiket Aktif (Sudah Lunas) -->
                            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 h-full">
                                <div class="text-center mb-8">
                                    <div class="inline-flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-3">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h3 class="text-xl font-extrabold text-gray-900">Tiket Anda Siap!</h3>
                                    <p class="text-sm text-gray-500 mt-1">Tunjukkan QR Code ini kepada petugas di pintu masuk.</p>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    @foreach($order->tickets as $index => $ticket)
                                        <!-- Desain Tiket Fisik / Boarding Pass -->
                                        <div class="bg-white border border-gray-200 rounded-2xl flex flex-col relative group shadow-sm hover:shadow-md transition-all">
                                            
                                            <!-- Header Tiket -->
                                            <div class="bg-blue-600 px-4 py-3 text-center rounded-t-2xl">
                                                <span class="text-xs font-black text-blue-100 uppercase tracking-widest">Tiket Masuk #{{ $index + 1 }}</span>
                                            </div>
                                            
                                            <!-- Garis Potong (Perforated Line) -->
                                            <div class="relative flex items-center w-full z-10">
                                                <!-- Lubang Kiri (Sesuaikan dengan warna background parent, yaitu putih) -->
                                                <div class="w-6 h-6 bg-white rounded-full absolute -left-3 border-r border-gray-200"></div>
                                                <!-- Garis putus-putus -->
                                                <div class="w-full border-t-2 border-dashed border-gray-200"></div>
                                                <!-- Lubang Kanan -->
                                                <div class="w-6 h-6 bg-white rounded-full absolute -right-3 border-l border-gray-200"></div>
                                            </div>

                                            <!-- Konten Tiket (QR Code & Kode) -->
                                            <div class="p-6 text-center flex-1 flex flex-col justify-center items-center rounded-b-2xl">
                                                
                                                <!-- Wrapper QR Code agar responsif dan tidak tumpah -->
                                                <div class="bg-white p-3 rounded-2xl border border-gray-100 shadow-sm mb-4 group-hover:border-blue-300 group-hover:shadow-md transition-all">
                                                    <div class="w-32 h-32 sm:w-28 sm:h-28 md:w-32 md:h-32 flex justify-center items-center [&>svg]:w-full [&>svg]:h-full [&>svg]:block">
                                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(128)->margin(1)->generate($ticket->ticket_code) !!}
                                                    </div>
                                                </div>
                                                
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1.5">Kode Referensi</p>
                                                <div class="bg-gray-50 py-2.5 px-4 rounded-xl border border-gray-200/80 w-full">
                                                    <!-- Gunakan break-all agar kode panjang tidak merusak layout -->
                                                    <span class="font-mono font-bold text-gray-800 tracking-widest text-sm sm:text-xs md:text-sm break-all">{{ $ticket->ticket_code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Panel Kadaluarsa -->
                            <div class="bg-red-50 rounded-3xl border border-red-100 p-8 flex flex-col justify-center items-center text-center h-full">
                                <svg class="w-16 h-16 text-red-400 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h3 class="text-xl font-extrabold text-gray-900 mb-2">Waktu Pembayaran Habis</h3>
                                <p class="text-sm text-gray-600 mb-6">Pesanan Anda telah dibatalkan oleh sistem karena melewati batas waktu 15 menit.</p>
                                <a href="{{ route('events.show', $order->event->slug) }}" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-bold rounded-xl shadow-sm text-white bg-gray-900 hover:bg-gray-800 transition-colors">
                                    Pesan Tiket Ulang
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS Countdown Logic -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countdown', (expiredAt) => ({
                timeDisplay: '00:00',
                timer: null,
                start() {
                    const countDownDate = new Date(expiredAt).getTime(); 
                    
                    this.timer = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = countDownDate - now;

                        if (distance < 0) {
                            clearInterval(this.timer);
                            this.timeDisplay = "HABIS";
                            setTimeout(() => window.location.reload(), 2000);
                            return;
                        }

                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        this.timeDisplay = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }, 1000);
                }
            }));
        });
    </script>

    <!-- Script Midtrans (Hanya dimuat jika status masih pending) -->
    @if($order->status === 'pending')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.getElementById('pay-button').onclick = function(){
                // Panggil snap.pay() dengan token yang sudah kita simpan di payment_url
                window.snap.pay('{{ $order->payment_url }}', {
                    onSuccess: function(result){
                        window.location.reload();
                    },
                    onPending: function(result){
                        window.location.reload();
                    },
                    onError: function(result){
                        alert("Pembayaran gagal!");
                    },
                    onClose: function(){
                        console.log('Popup ditutup sebelum pembayaran diselesaikan');
                    }
                });
            };
        </script>
    @endif
</x-app-layout>