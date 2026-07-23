<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-blue-700 relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" fill="none" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="currentColor"></path>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative py-20 text-center sm:py-32">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6">
                Temukan Pengalaman <br class="hidden sm:block" /> Tak Terlupakan
            </h1>
            <p class="text-lg sm:text-xl text-blue-100 mb-10 max-w-2xl mx-auto font-medium">
                Dari workshop inspiratif hingga konser memukau, dapatkan tiketmu dengan mudah, aman, dan instan di AmikomEvent.
            </p>
            <a href="#events" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-blue-700 bg-white rounded-full shadow-xl hover:bg-blue-50 hover:scale-105 transition-all duration-300">
                Eksplor Event Sekarang
                <svg class="w-5 h-5 ml-2 -mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </a>
        </div>
    </div>

    <!-- Event Section -->
    <div id="events" class="py-16 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Event Mendatang</h2>
            </div>

            @if($events->isEmpty())
                <div class="text-center py-16 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <svg class="mx-auto h-20 w-20 text-gray-300 mb-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <h3 class="text-xl font-extrabold text-gray-900">Belum Ada Event</h3>
                    <p class="text-gray-500 mt-2 max-w-sm mx-auto">Saat ini belum ada event yang diterbitkan. Silakan kembali lagi nanti untuk melihat daftar event terbaru.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-gray-100 overflow-hidden transition-all duration-300 group flex flex-col relative transform hover:-translate-y-2">
                            <!-- Image Section -->
                            <div class="h-56 w-full bg-gray-200 relative overflow-hidden">
                                @if($event->banner_image)
                                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                @else
                                    <div class="flex items-center justify-center h-full w-full bg-gray-100 text-gray-400">
                                        <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-1.5 rounded-full text-xs font-extrabold text-blue-700 shadow-sm uppercase tracking-wider">
                                    {{ $event->category->name ?? 'Umum' }}
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-xl font-extrabold text-gray-900 mb-4 line-clamp-2 leading-snug group-hover:text-blue-700 transition-colors duration-200">
                                    {{ $event->title }}
                                </h3>
                                
                                <div class="text-sm text-gray-600 space-y-3 mb-6 flex-1">
                                    <!-- Date & Time -->
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center mr-3 shrink-0">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <span class="block font-bold text-gray-900">{{ $event->event_date->format('d M Y') }}</span>
                                            <span class="block text-xs">{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</span>
                                        </div>
                                    </div>
                                    <!-- Location -->
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-red-50 flex items-center justify-center mr-3 shrink-0">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </div>
                                        <span class="truncate font-medium">{{ $event->location }}</span>
                                    </div>
                                </div>
                                
                                <!-- Action Footer -->
                                <div class="pt-5 border-t border-gray-100 flex justify-between items-center mt-auto">
                                    <div class="flex items-center text-sm font-extrabold text-blue-600 group-hover:text-blue-800 transition-colors">
                                        <span>Lihat Detail</span>
                                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Link Overlay -->
                            <a href="{{ route('events.show', $event->slug) }}" class="absolute inset-0 z-10">
                                <span class="sr-only">Lihat Detail {{ $event->title }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    
    <!-- Footer Sederhana -->
    <footer class="bg-white border-t border-gray-200 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="flex items-center mb-4 md:mb-0">
                <svg class="w-8 h-8 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span class="text-xl font-extrabold text-gray-900 tracking-tight">AmikomEvent</span>
            </div>
            <div class="text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} AmikomEventHub. Dibuat untuk UAS Digital Bisnis.
            </div>
        </div>
    </footer>
</x-app-layout>