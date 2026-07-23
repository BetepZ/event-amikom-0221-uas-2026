<x-app-layout>
    <div class="bg-gray-50 py-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Breadcrumb Navigation -->
            <nav class="flex items-center text-sm font-medium text-gray-500 mb-8 space-x-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-gray-400">{{ $event->category->name ?? 'Kategori' }}</span>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-gray-900 truncate max-w-xs">{{ $event->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <!-- Kolom Kiri: Detail & Informasi Utama -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Banner Image -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative group">
                        @if($event->banner_image)
                            <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-80 sm:h-96 object-cover object-center group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-80 sm:h-96 bg-gray-100 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-bold text-blue-700 uppercase tracking-wide shadow-sm">
                            {{ $event->category->name ?? 'Umum' }}
                        </div>
                    </div>

                    <!-- Header & Judul Acara -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4 mb-6">
                            <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight leading-tight">
                                {{ $event->title }}
                            </h1>
                            
                            <!-- Rating Badge -->
                            @if($event->reviews->count() > 0)
                                <div class="flex items-center space-x-1.5 bg-yellow-50 px-3 py-2 rounded-xl border border-yellow-100 shrink-0">
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    <span class="text-sm font-bold text-yellow-700">{{ number_format($event->reviews->avg('rating'), 1) }}</span>
                                    <span class="text-xs text-yellow-600 font-medium">({{ $event->reviews->count() }} ulasan)</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Waktu & Lokasi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0 mr-4">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal & Waktu</h3>
                                    <p class="text-base font-bold text-gray-900">{{ $event->event_date->format('l, d F Y') }}</p>
                                    <p class="text-sm text-gray-600 mt-0.5">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0 mr-4">
                                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Lokasi Acara</h3>
                                    <p class="text-base font-bold text-gray-900">{{ $event->location }}</p>
                                    <a href="https://maps.google.com/?q={{ urlencode($event->location) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium mt-1">
                                        Lihat Peta
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi Acara -->
                        <div class="mt-8">
                            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                Deskripsi Acara
                            </h2>
                            <div class="prose max-w-none text-gray-600 leading-relaxed whitespace-pre-line text-sm sm:text-base">
                                {{ $event->description }}
                            </div>
                        </div>
                    </div>

                    <!-- Ulasan Pengunjung -->
                    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            Ulasan Pengunjung
                        </h2>
                        
                        @if($event->reviews->isEmpty())
                            <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                                <p class="text-gray-500 text-sm font-medium">Belum ada ulasan untuk acara ini.</p>
                                <p class="text-gray-400 text-xs mt-1">Ulasan akan muncul setelah acara diselenggarakan.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($event->reviews as $review)
                                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                                        <div class="flex justify-between items-start mb-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm uppercase shadow-sm">
                                                    {{ substr($review->user->name, 0, 2) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900">{{ $review->user->name }}</p>
                                                    <p class="text-xs text-gray-500 font-medium">{{ $review->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                @endfor
                                            </div>
                                        </div>
                                        @if($review->comment)
                                            <p class="text-sm text-gray-700 mt-2 leading-relaxed bg-white p-3 rounded-xl border border-gray-100">"{{ $review->comment }}"</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kolom Kanan: Pilihan Tiket (Sticky Panel) -->
                <div class="lg:col-span-1">
                    <!-- Gunakan top-24 agar tidak tertutup navbar saat di-scroll -->
                    <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-lg border border-gray-100 sticky top-24"
                         x-data="{ 
                            selectedTier: null, 
                            quantity: 1, 
                            price: 0,
                            selectTicket(id, price) {
                                this.selectedTier = id;
                                this.price = price;
                                this.quantity = 1;
                            },
                            get total() {
                                return this.price * this.quantity;
                            }
                         }">
                        
                        <div class="flex items-center mb-6">
                            <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            <h3 class="text-xl font-extrabold text-gray-900">Pilih Tiket</h3>
                        </div>
                        
                        <!-- Form Checkout -->
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <input type="hidden" name="ticket_tier_id" x-bind:value="selectedTier">
                            <input type="hidden" name="quantity" x-bind:value="quantity">

                            <div class="space-y-4 mb-6">
                                @forelse($event->ticketTiers as $tier)
                                    <!-- Opsi Tiket Selectable Card -->
                                    <div @click="selectTicket({{ $tier->id }}, {{ $tier->price }})" 
                                         :class="{'border-blue-600 bg-blue-50 ring-2 ring-blue-600 shadow-md': selectedTier === {{ $tier->id }}, 'border-gray-200 bg-white hover:border-blue-300 hover:bg-gray-50': selectedTier !== {{ $tier->id }}}"
                                         class="relative block cursor-pointer rounded-2xl border p-5 focus:outline-none transition-all duration-200">
                                        
                                        <!-- Checkmark Icon (Muncul jika dipilih) -->
                                        <div x-show="selectedTier === {{ $tier->id }}" class="absolute -top-3 -right-3 bg-blue-600 rounded-full p-1 shadow-sm">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>

                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-base font-bold text-gray-900">{{ $tier->name }}</p>
                                            <p class="text-lg font-extrabold text-blue-600">
                                                {{ $tier->price == 0 ? 'Gratis' : 'Rp ' . number_format($tier->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="flex justify-between items-center text-sm mt-3 pt-3 border-t border-gray-200/50">
                                            <span class="text-gray-500 font-medium flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                Sisa Kuota
                                            </span>
                                            <span class="font-bold {{ $tier->capacity < 10 ? 'text-red-600' : 'text-gray-700' }}">
                                                {{ $tier->capacity }} Tiket
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                        <p class="text-gray-500 text-sm font-medium">Tiket belum tersedia.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Selector Jumlah (Akan muncul perlahan dengan efek collapse jika tiket diklik) -->
                            <div x-show="selectedTier !== null" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 class="mb-6 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <label class="block text-sm font-bold text-gray-700 mb-3 text-center">Jumlah Tiket</label>
                                <div class="flex items-center justify-center">
                                    <div class="flex items-center bg-white border border-gray-300 rounded-xl overflow-hidden shadow-sm">
                                        <button type="button" @click="if(quantity > 1) quantity--" class="px-4 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-blue-600 focus:outline-none transition-colors font-bold text-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                                        </button>
                                        <input type="number" readonly x-model="quantity" class="w-16 text-center border-none p-0 focus:ring-0 text-gray-900 font-extrabold text-lg pointer-events-none">
                                        <button type="button" @click="if(quantity < 5) quantity++" class="px-4 py-2 bg-gray-50 text-gray-600 hover:bg-gray-100 hover:text-blue-600 focus:outline-none transition-colors font-bold text-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-400 mt-3 text-center font-medium">Batas maksimal pembelian: 5 tiket</p>
                            </div>

                            <!-- Ringkasan Total & Tombol Beli -->
                            <div class="pt-2">
                                <div class="flex justify-between items-center mb-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                                    <span class="text-blue-900 font-bold text-sm">Total Harga</span>
                                    <span class="text-2xl font-extrabold text-blue-700" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(total)">Rp 0</span>
                                </div>
                                
                                @auth
                                <button type="submit"
                                        :disabled="selectedTier === null"
                                        :class="{'opacity-50 cursor-not-allowed bg-gray-300': selectedTier === null, 'bg-blue-600 hover:bg-blue-700 hover:shadow-lg transform hover:-translate-y-0.5': selectedTier !== null}"
                                        class="w-full flex justify-center items-center px-6 py-4 rounded-xl text-base font-extrabold text-white transition-all duration-200">
                                    <span x-show="price == 0" class="flex items-center">
                                        Klaim Tiket Gratis
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                    <span x-show="price > 0" class="flex items-center">
                                        Lanjut ke Pembayaran
                                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </span>
                                </button>
                                @else
                                <a href="{{ route('login') }}" class="w-full flex justify-center items-center px-6 py-4 rounded-xl text-base font-extrabold text-white bg-gray-900 hover:bg-gray-800 transition-all duration-200 shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    Login untuk Membeli
                                </a>
                                @endauth
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>