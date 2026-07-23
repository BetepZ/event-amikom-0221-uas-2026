<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan daftar pesanan (Tiket Saya)
     */
    public function index()
    {
        // 1. Ambil semua pesanan milik user yang sedang login beserta relasi tiketnya
        $orders = Order::with(['event', 'ticketTier', 'tickets'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        // 2. Ambil daftar ID Event yang sudah pernah diulas oleh user ini (agar UI tombolnya cerdas)
        $reviewedEventIds = \App\Models\Review::where('user_id', Auth::id())
            ->pluck('event_id')
            ->toArray();

        return view('dashboard', compact('orders', 'reviewedEventIds'));
    }
}
