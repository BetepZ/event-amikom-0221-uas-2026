<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ __('Tiket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen" x-data="dashboardUI()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Notifikasi -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-md shadow-sm flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-md shadow-sm flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <!-- Tampilan Kosong (Empty State) -->
            @if($orders->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100 p-16 text-center">
                    <svg class="mx-auto h-20 w-20 text-gray-300 mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    <h3 class="text-xl font-extrabold text-gray-900">Belum ada tiket yang dibeli</h3>
                    <p class="text-base text-gray-500 mt-2 mb-8">Mulai eksplorasi dan temukan event seru di sekitarmu!</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-bold rounded-full shadow-md text-white bg-blue-600 hover:bg-blue-700 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        Cari Event Sekarang
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            @else
                
                <!-- Grid Tiket -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col relative group">
                            
                            <!-- Badge Status -->
                            <div class="absolute top-4 right-4 z-10">
                                @if($order->status === 'paid')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm backdrop-blur-sm">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Lunas
                                    </span>
                                @elseif($order->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm backdrop-blur-sm animate-pulse">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Menunggu Pembayaran
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm backdrop-blur-sm">
                                        Kedaluwarsa
                                    </span>
                                @endif
                            </div>

                            <!-- Gambar Header -->
                            <div class="h-48 bg-gray-200 relative overflow-hidden">
                                @if($order->event->banner_image)
                                    <img src="{{ asset('storage/' . $order->event->banner_image) }}" alt="{{ $order->event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm bg-gray-100">
                                        <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                                <div class="absolute bottom-4 left-5 right-5">
                                    <h4 class="text-white font-extrabold text-xl leading-tight line-clamp-2">{{ $order->event->title }}</h4>
                                </div>
                            </div>

                            <!-- Informasi Pesanan -->
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center text-sm text-gray-600 mb-6 space-x-6">
                                    <span class="flex items-center font-medium">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $order->event->event_date->format('d M Y') }}
                                    </span>
                                    <span class="flex items-center font-medium">
                                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                                        {{ $order->quantity }}x {{ $order->ticketTier->name }}
                                    </span>
                                </div>
                                
                                <!-- Harga -->
                                <div class="mb-4">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Harga</p>
                                    <p class="text-lg font-extrabold text-gray-900">
                                        {{ $order->total_price == 0 ? 'Gratis' : 'Rp ' . number_format($order->total_price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Aksi (Garis putus-putus ala tiket) -->
                                <div class="mt-auto pt-5 border-t-2 border-dashed border-gray-200 flex flex-wrap items-center gap-2">
                                    @if($order->status === 'paid')
                                        @php
                                            $hasAttended = $order->tickets->contains('status', 'used');
                                            $hasReviewed = in_array($order->event_id, $reviewedEventIds);
                                            $eventEndDateTime = \Carbon\Carbon::parse($order->event->event_date->format('Y-m-d') . ' ' . $order->event->end_time);
                                            $isEventFinished = now()->greaterThanOrEqualTo($eventEndDateTime);
                                        @endphp
                                        
                                        <!-- Tombol Sertifikat -->
                                        @if($hasAttended && $order->event->is_certificate_enabled && $isEventFinished)
                                            <a href="{{ route('certificates.download', $order->id) }}" class="inline-flex items-center px-4 py-2 border border-indigo-200 rounded-xl text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 hover:border-indigo-300 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Sertifikat
                                            </a>
                                        @endif

                                        <!-- Tombol Ulasan -->
                                        @if($hasAttended && !$hasReviewed)
                                            <button @click="openReview({{ $order->event_id }}, '{{ addslashes($order->event->title) }}')" class="inline-flex items-center px-4 py-2 border border-amber-200 rounded-xl text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 hover:border-amber-300 transition-colors">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                                Beri Ulasan
                                            </button>
                                        @elseif($hasAttended && $hasReviewed)
                                            <span class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-500 bg-gray-50 cursor-default">
                                                <svg class="w-4 h-4 mr-1.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                Telah Diulas
                                            </span>
                                        @endif

                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition-colors ml-auto">
                                            Lihat Tiket
                                            <svg class="w-4 h-4 ml-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    @elseif($order->status === 'pending')
                                        <a href="{{ route('orders.show', $order->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-transparent rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                                            Bayar Sekarang
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        </a>
                                    @else
                                        <a href="{{ route('orders.show', $order->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 bg-gray-50 hover:bg-gray-100 transition-colors">
                                            Detail Pesanan
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

        <!-- Modal Ulasan -->
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                <!-- Background overlay -->
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" @click="showModal = false" aria-hidden="true"></div>
                
                <!-- Trik untuk memusatkan modal di tengah layar -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="event_id" x-model="eventId">
                        <input type="hidden" name="rating" x-model="rating">
                        
                        <div class="bg-white px-6 pt-8 pb-6">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-50 rounded-full mb-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                            </div>
                            <h3 class="text-2xl leading-6 font-extrabold text-gray-900 text-center mb-2" id="modal-title">
                                Bagikan Pengalamanmu
                            </h3>
                            <p class="text-sm text-gray-500 text-center mb-8 px-4">Penilaian jujur Anda akan membantu pengunjung lain di event <span x-text="eventTitle" class="font-bold text-gray-700"></span>.</p>
                            
                            <!-- Star Rating Interaktif -->
                            <div class="flex justify-center space-x-3 mb-8">
                                <template x-for="i in 5">
                                    <svg @click="rating = i" @mouseenter="hoverRating = i" @mouseleave="hoverRating = 0" 
                                         :class="{'text-amber-400 scale-110 drop-shadow-sm': (hoverRating ? hoverRating >= i : rating >= i), 'text-gray-200': !(hoverRating ? hoverRating >= i : rating >= i)}"
                                         class="w-10 h-10 cursor-pointer transition-all duration-150 transform" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </template>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Komentar <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <textarea name="comment" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full text-sm border-gray-300 rounded-xl p-3 placeholder-gray-400 transition-colors" placeholder="Ceritakan keseruan dan pengalamanmu di acara ini..."></textarea>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 sm:space-x-reverse border-t border-gray-100">
                            <button type="button" @click="showModal = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 sm:mt-0 sm:w-auto transition-all">
                                Nanti Saja
                            </button>
                            <button type="submit" :disabled="rating === 0" :class="{'opacity-50 cursor-not-allowed bg-blue-400': rating === 0, 'bg-blue-600 hover:bg-blue-700 hover:shadow-md transform hover:-translate-y-0.5': rating > 0}" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2.5 text-sm font-bold text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:w-auto transition-all duration-200">
                                Kirim Ulasan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- AlpineJS State untuk Modal -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardUI', () => ({
                showModal: false,
                eventId: null,
                eventTitle: '',
                rating: 0,
                hoverRating: 0,
                
                openReview(id, title) {
                    this.eventId = id;
                    this.eventTitle = title;
                    this.rating = 0;
                    this.hoverRating = 0;
                    this.showModal = true;
                }
            }));
        });
    </script>
</x-app-layout>