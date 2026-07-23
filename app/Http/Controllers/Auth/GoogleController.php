<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleController extends Controller
{
    /**
     * Mengarahkan user ke halaman login Google.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Menerima balasan (callback) dari Google setelah user memilih akun.
     */
    public function callback()
    {
        try {
            // Ambil data user dari Google
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user sudah ada berdasarkan email.
            // Jika ada, update data google_id. Jika belum, buat user baru.
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    // Role otomatis 'buyer' sesuai default database
                ]
            );

            // Login user tersebut
            Auth::login($user);

            // Arahkan ke dashboard Breeze
            return redirect()->intended(route('dashboard', absolute: false));
        } catch (Exception $e) {
            // Jika terjadi error (misal user membatalkan login)
            return redirect()->route('login')->with('error', 'Terjadi kesalahan saat login menggunakan Google.');
        }
    }
}
