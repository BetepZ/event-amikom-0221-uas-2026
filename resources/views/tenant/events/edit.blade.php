<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-gray-800">
            <a href="{{ route('tenant.dashboard') }}" class="hover:text-blue-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Edit Event: ') }} <span class="font-normal text-gray-500">{{ $event->title }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Pesan Error -->
            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                    <h3 class="text-sm font-bold text-red-800">Gagal menyimpan perubahan:</h3>
                    <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Edit Utama -->
            <form action="{{ route('tenant.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Section 1: Informasi Dasar -->
                <div class="bg-white px-4 py-5 shadow-sm border border-gray-100 sm:rounded-3xl sm:p-8">
                    <div class="md:grid md:grid-cols-3 md:gap-8">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-bold text-gray-900">Informasi Dasar</h3>
                            <p class="mt-1 text-sm text-gray-500">Perbarui detail utama mengenai acara yang akan diselenggarakan.</p>
                        </div>
                        <div class="mt-5 space-y-5 md:col-span-2 md:mt-0">
                            
                            <div>
                                <x-input-label for="title" value="Judul Event *" class="font-bold mb-1" />
                                <x-text-input id="title" name="title" type="text" class="block w-full rounded-xl border-gray-300" :value="old('title', $event->title)" required />
                            </div>

                            <div>
                                <x-input-label for="category_id" value="Kategori *" class="font-bold mb-1" />
                                <select id="category_id" name="category_id" class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <x-input-label for="event_date" value="Tanggal Event *" class="font-bold mb-1" />
                                    <x-text-input id="event_date" name="event_date" type="date" class="block w-full rounded-xl border-gray-300" :value="old('event_date', $event->event_date->format('Y-m-d'))" required />
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <x-input-label for="start_time" value="Mulai *" class="font-bold mb-1" />
                                        <x-text-input id="start_time" name="start_time" type="time" class="block w-full rounded-xl border-gray-300" :value="old('start_time', \Carbon\Carbon::parse($event->start_time)->format('H:i'))" required />
                                    </div>
                                    <div>
                                        <x-input-label for="end_time" value="Selesai *" class="font-bold mb-1" />
                                        <x-text-input id="end_time" name="end_time" type="time" class="block w-full rounded-xl border-gray-300" :value="old('end_time', \Carbon\Carbon::parse($event->end_time)->format('H:i'))" required />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="location" value="Lokasi *" class="font-bold mb-1" />
                                <x-text-input id="location" name="location" type="text" class="block w-full rounded-xl border-gray-300" :value="old('location', $event->location)" required />
                            </div>

                            <div>
                                <x-input-label for="description" value="Deskripsi Lengkap *" class="font-bold mb-1" />
                                <textarea id="description" name="description" rows="5" class="block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" required>{{ old('description', $event->description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Media -->
                <div class="bg-white px-4 py-5 shadow-sm border border-gray-100 sm:rounded-3xl sm:p-8">
                    <div class="md:grid md:grid-cols-3 md:gap-8">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-bold text-gray-900">Media & Ekstra</h3>
                            <p class="mt-1 text-sm text-gray-500">Perbarui banner atau pengaturan e-sertifikat.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Banner Saat Ini</label>
                                @if($event->banner_image)
                                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="Banner" class="w-full max-w-sm h-48 object-cover rounded-2xl border border-gray-200 mb-3 shadow-sm">
                                @else
                                    <div class="w-full max-w-sm h-32 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 mb-3 border border-gray-200">Tidak ada banner</div>
                                @endif
                                
                                <label class="block text-sm font-bold text-gray-700 mb-1 mt-4">Ganti Banner <span class="text-gray-400 font-normal">(Opsional)</span></label>
                                <input type="file" name="banner_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-colors">
                                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            </div>

                            <div class="flex items-start bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                                <div class="flex h-5 items-center">
                                    <input id="is_certificate_enabled" name="is_certificate_enabled" type="checkbox" value="1" {{ old('is_certificate_enabled', $event->is_certificate_enabled) ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_certificate_enabled" class="font-bold text-gray-900">Aktifkan E-Sertifikat</label>
                                    <p class="text-gray-600 mt-1">Sistem akan otomatis membuat sertifikat PDF bagi peserta yang hadir.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Section 3: Read-Only Tiket -->
                <div class="bg-gray-50/80 px-4 py-5 shadow-inner border border-gray-200 sm:rounded-3xl sm:p-8 opacity-80">
                    <div class="md:grid md:grid-cols-3 md:gap-8">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Tiket (Terkunci)
                            </h3>
                            <p class="mt-1 text-sm text-gray-600">Demi menjaga integritas riwayat transaksi dan data pembeli, harga dan jenis tiket tidak dapat diubah setelah event diterbitkan.</p>
                        </div>
                        
                        <div class="mt-5 space-y-3 md:col-span-2 md:mt-0">
                            @foreach($event->ticketTiers as $tier)
                                <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                                    <div>
                                        <p class="font-bold text-gray-900">{{ $tier->name }}</p>
                                        <p class="text-sm text-gray-500">Kuota Awal: {{ $tier->capacity }} tiket</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-extrabold text-blue-600">{{ $tier->price == 0 ? 'Gratis' : 'Rp ' . number_format($tier->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Footer: Action Buttons (Save & Delete) -->
                <div class="flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-4 pt-4 border-t border-gray-200">
                    
                    <!-- Fitur Delete AlpineJS Inline (Tanpa Alert Browser) -->
                    <div x-data="{ confirmingDelete: false }">
                        <button type="button" x-show="!confirmingDelete" @click="confirmingDelete = true" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-red-700 rounded-xl font-bold text-sm hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus Event
                        </button>

                        <div x-show="confirmingDelete" style="display: none;" class="flex items-center space-x-3 bg-red-50 px-4 py-2 rounded-xl border border-red-200">
                            <span class="text-sm font-bold text-red-800">Yakin ingin menghapus secara permanen?</span>
                            <button type="button" @click="confirmingDelete = false" class="text-gray-500 hover:text-gray-900 text-sm font-bold px-2">Batal</button>
                            
                            <!-- Form khusus Delete -->
                            <form action="{{ route('tenant.events.destroy', $event->id) }}" method="POST" class="inline m-0 p-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-lg font-bold text-sm hover:bg-red-700 shadow-sm transition-colors">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tombol Save -->
                    <div class="flex justify-end gap-3 w-full sm:w-auto">
                        <a href="{{ route('tenant.dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 rounded-xl font-bold text-sm text-gray-700 hover:bg-gray-50 shadow-sm transition-colors text-center w-full sm:w-auto justify-center">
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-blue-700 shadow-sm transition-colors text-center w-full sm:w-auto justify-center">
                            Simpan Perubahan
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>