<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Event Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Menampilkan pesan error validasi global jika ada -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input Anda:</h3>
                            <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('tenant.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Section 1: Informasi Dasar -->
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Dasar</h3>
                            <p class="mt-1 text-sm text-gray-500">Berikan detail utama mengenai acara yang akan diselenggarakan.</p>
                        </div>
                        <div class="mt-5 space-y-4 md:col-span-2 md:mt-0">
                            
                            <div>
                                <x-input-label for="title" value="Judul Event *" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required placeholder="Misal: Amikom Tech Summit 2026" />
                            </div>

                            <div>
                                <x-input-label for="category_id" value="Kategori *" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="event_date" value="Tanggal Event *" />
                                    <x-text-input id="event_date" name="event_date" type="date" class="mt-1 block w-full" :value="old('event_date')" required />
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <x-input-label for="start_time" value="Waktu Mulai *" />
                                        <x-text-input id="start_time" name="start_time" type="time" class="mt-1 block w-full" :value="old('start_time')" required />
                                    </div>
                                    <div>
                                        <x-input-label for="end_time" value="Waktu Selesai *" />
                                        <x-text-input id="end_time" name="end_time" type="time" class="mt-1 block w-full" :value="old('end_time')" required />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="location" value="Lokasi (Nama Tempat / URL Online) *" />
                                <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location')" required placeholder="Gedung BSC Amikom / Link Zoom" />
                            </div>

                            <div>
                                <x-input-label for="description" value="Deskripsi Lengkap *" />
                                <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm" required placeholder="Jelaskan detail acara Anda...">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Media & Ekstra</h3>
                            <p class="mt-1 text-sm text-gray-500">Tambahkan banner acara dan atur penerbitan e-sertifikat.</p>
                        </div>
                        <div class="mt-5 space-y-4 md:col-span-2 md:mt-0">
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Banner Event</label>
                                <div class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="banner_image" class="relative cursor-pointer rounded-md bg-white font-medium text-blue-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 hover:text-blue-500">
                                                <span>Upload a file</span>
                                                <input id="banner_image" name="banner_image" type="file" accept="image/*" class="sr-only">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, WEBP up to 2MB</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start mt-4">
                                <div class="flex h-5 items-center">
                                    <input id="is_certificate_enabled" name="is_certificate_enabled" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_certificate_enabled" class="font-medium text-gray-700">Aktifkan E-Sertifikat Otomatis</label>
                                    <p class="text-gray-500">Centang jika acara ini memberikan sertifikat. (Peserta akan mendapatkannya otomatis setelah acara selesai/di-scan).</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6" 
                     x-data="{ 
                         tiers: [
                             { name: 'Regular', price: 0, capacity: 100 }
                         ],
                         addTier() {
                             this.tiers.push({ name: '', price: 0, capacity: 0 });
                         },
                         removeTier(index) {
                             if(this.tiers.length > 1) {
                                 this.tiers.splice(index, 1);
                             }
                         }
                     }">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Jenis Tiket</h3>
                            <p class="mt-1 text-sm text-gray-500">Atur harga dan kuota. Anda bisa membuat banyak jenis (Early Bird, VIP, dll). Isi harga 0 untuk tiket Gratis.</p>
                            
                            <button type="button" @click="addTier()" class="mt-4 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                + Tambah Jenis Tiket
                            </button>
                        </div>
                        
                        <div class="mt-5 space-y-4 md:col-span-2 md:mt-0">
                            <template x-for="(tier, index) in tiers" :key="index">
                                <div class="flex items-center gap-4 p-4 border rounded-md bg-gray-50 relative">
                                    
                                    <button type="button" @click="removeTier(index)" x-show="tiers.length > 1" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                        &times;
                                    </button>

                                    <div class="w-1/3">
                                        <label class="block text-xs font-medium text-gray-700">Nama Tiket</label>
                                        <input type="text" x-bind:name="'tiers[' + index + '][name]'" x-model="tier.name" required class="mt-1 block w-full text-sm border-gray-300 rounded-md" placeholder="Cth: Early Bird">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-xs font-medium text-gray-700">Harga (Rp)</label>
                                        <input type="number" x-bind:name="'tiers[' + index + '][price]'" x-model="tier.price" required min="0" class="mt-1 block w-full text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="w-1/3">
                                        <label class="block text-xs font-medium text-gray-700">Kuota (Kapasitas)</label>
                                        <input type="number" x-bind:name="'tiers[' + index + '][capacity]'" x-model="tier.capacity" required min="1" class="mt-1 block w-full text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('tenant.dashboard') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Batal
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Simpan & Terbitkan Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>