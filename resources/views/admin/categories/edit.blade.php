<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="name" value="Nama Kategori *" class="mb-2 font-bold" />
                            <x-text-input id="name" name="name" type="text" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" :value="old('name', $category->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 text-sm font-bold text-gray-600 hover:text-gray-900 mr-4 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-purple-600 border border-transparent rounded-xl font-bold text-sm text-white hover:bg-purple-700 shadow-sm transition-all duration-200">
                                Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>