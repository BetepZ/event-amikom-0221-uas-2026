<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat order miliknya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Muat relasi yang dibutuhkan untuk ditampilkan di halaman
        $order->load(['event', 'ticketTier', 'tickets']);

        return view('orders.show', compact('order'));
    }
}
