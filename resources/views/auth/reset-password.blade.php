<x-guest-layout>
    <!-- Header Instruksi -->
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-50 rounded-full mb-4">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight">Buat Sandi Baru</h2>
        <p class="text-sm text-gray-500 mt-2 font-medium">Silakan masukkan kata sandi baru untuk akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1.5">{{ __('Email') }}</label>
            <!-- Kita buat readonly agar user tidak bisa mengubah email yang disisipkan dari link -->
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" 
                   class="block w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 cursor-not-allowed" 
                   readonly>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-gray-700 mb-1.5">{{ __('Sandi Baru') }}</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 transition-colors placeholder-gray-400"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-1.5">{{ __('Konfirmasi Sandi Baru') }}</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                   class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm px-4 py-3 transition-colors placeholder-gray-400"
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center items-center px-4 py-3 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                {{ __('Simpan Sandi Baru') }}
            </button>
        </div>
    </form>
</x-guest-layout>