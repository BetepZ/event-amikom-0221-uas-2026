<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Kategori') }}
            </h2>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-purple-700 shadow-sm transition-all duration-200">
                + Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Daftar Kategori Event</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold">Nama Kategori</th>
                                <th scope="col" class="px-6 py-4 font-bold">Slug URL</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Jumlah Event</th>
                                <th scope="col" class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $category->name }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <!-- Menampilkan hasil withCount('events') dari controller -->
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $category->events_count }} Event
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg font-bold text-xs text-gray-700 hover:bg-gray-50 shadow-sm transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kategori ini? (Pastikan tidak ada event yang memakainya)');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 rounded-lg font-bold text-xs text-red-700 hover:bg-red-100 shadow-sm transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 font-medium">
                                        Belum ada kategori yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-white">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>