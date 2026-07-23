<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScannerController extends Controller
{
    /**
     * Menampilkan Halaman Kamera Scanner
     */
    public function index()
    {
        return view('tenant.scanner');
    }

    /**
     * API Endpoint untuk memvalidasi tiket yang di-scan (AJAX)
     */
    public function verify(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
        ]);

        // 1. Cari tiket beserta relasi pesanan dan event-nya
        $ticket = Ticket::with(['order.event', 'order.user'])
            ->where('ticket_code', $request->ticket_code)
            ->first();

        // 2. Cek apakah tiket ditemukan
        if (!$ticket) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan / Palsu!'
            ], 404);
        }

        // 3. Cek Otorisasi (Apakah event ini benar milik tenant yang sedang login?)
        if ($ticket->order->event->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket ini bukan untuk acara Anda!'
            ], 403);
        }

        // 4. Cek apakah tiket sudah pernah digunakan
        if ($ticket->status === 'used') {
            return response()->json([
                'success' => false,
                'message' => 'Tiket SUDAH DIGUNAKAN pada ' . $ticket->scanned_at->format('d M Y, H:i'),
                'data' => [
                    'buyer_name' => $ticket->order->user->name,
                    'event_title' => $ticket->order->event->title,
                    'ticket_tier' => $ticket->order->ticketTier->name,
                ]
            ], 400); // Bad request
        }

        // 5. Jika lolos semua validasi, Tandai tiket sebagai 'used' (Hadir)
        $ticket->update([
            'status' => 'used',
            'scanned_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tiket Valid! Check-in Berhasil.',
            'data' => [
                'buyer_name' => $ticket->order->user->name,
                'event_title' => $ticket->order->event->title,
                'ticket_tier' => $ticket->order->ticketTier->name,
            ]
        ]);
    }
}
