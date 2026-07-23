<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dasbor utama Admin
     */
    public function index()
    {
        // 1. Hitung total uang transaksi yang lunas (GMV)
        $totalGmv = Order::where('status', 'paid')->sum('total_price');

        // 2. Hitung total event di platform
        $totalEvents = Event::count();

        // 3. Hitung total pengguna terdaftar
        $totalUsers = User::count();

        // 4. Ambil data semua pengguna untuk ditampilkan di tabel (dengan paginasi)
        $users = User::latest()->paginate(10);

        // Kirim semua variabel ke tampilan Blade
        return view('admin.dashboard', compact('totalGmv', 'totalEvents', 'totalUsers', 'users'));
    }

    /**
     * Memperbarui Role (Hak Akses) Pengguna
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:buyer,tenant'
        ]);

        // Proteksi: Mencegah Admin menurunkan pangkatnya sendiri secara tidak sengaja
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tindakan ditolak: Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', "Hak akses {$user->name} berhasil diubah menjadi " . ucfirst($request->role) . ".");
    }
}
