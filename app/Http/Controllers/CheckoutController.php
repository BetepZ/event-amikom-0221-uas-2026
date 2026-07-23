<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketTier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input dasar
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'ticket_tier_id' => 'required|exists:ticket_tiers,id',
            'quantity' => 'required|integer|min:1|max:5',
        ]);

        try {
            // Memulai Transaksi Database
            DB::beginTransaction();

            // 2. Ambil data tiket dengan LOCK agar tidak terjadi rebutan (Race Condition)
            $tier = TicketTier::where('id', $request->ticket_tier_id)
                ->where('event_id', $request->event_id)
                ->lockForUpdate()
                ->firstOrFail();

            // 3. Cek apakah stok masih cukup
            if ($tier->capacity < $request->quantity) {
                return back()->with('error', 'Maaf, sisa kuota tiket tidak mencukupi.');
            }

            // 4. TAHAN STOK (Reserved Ticket) - Kurangi kapasitas sekarang juga
            $tier->capacity -= $request->quantity;
            $tier->save();

            // 5. Kalkulasi harga dan buat nomor order
            $totalPrice = $tier->price * $request->quantity;
            $orderNumber = 'ORD-' . strtoupper(Str::random(8));

            // 6. Buat Record Order (Status Pending)
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'event_id' => $request->event_id,
                'ticket_tier_id' => $tier->id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'status' => 'pending', // Menunggu pembayaran
                'expired_at' => now()->addMinutes(15), // Batas waktu 15 menit
            ]);

            // 7. BYPASS TIKET GRATIS ATAU GENERATE MIDTRANS TOKEN
            if ($totalPrice == 0) {
                $order->update(['status' => 'paid']);

                // Langsung terbitkan tiket yang bisa di-scan
                for ($i = 0; $i < $order->quantity; $i++) {
                    Ticket::create([
                        'order_id' => $order->id,
                        'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
                        'status' => 'valid'
                    ]);
                }
            } else {
                // --- KONFIGURASI MIDTRANS ---
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production');
                \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                // Siapkan data transaksi yang akan dikirim ke Midtrans
                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => $order->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                    ],
                    'item_details' => [
                        [
                            'id' => $tier->id,
                            'price' => $tier->price,
                            'quantity' => $order->quantity,
                            'name' => substr($tier->name, 0, 50), // Midtrans membatasi nama item maks 50 karakter
                        ]
                    ]
                ];

                // Minta token Snap ke Midtrans dan simpan di tabel orders
                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['payment_url' => $snapToken]);
            }

            DB::commit();

            // Arahkan ke halaman detail pesanan
            return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
}
