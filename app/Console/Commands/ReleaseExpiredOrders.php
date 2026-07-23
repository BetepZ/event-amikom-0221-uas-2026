<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReleaseExpiredOrders extends Command
{
    /**
     * Nama perintah yang akan dipanggil di terminal.
     */
    protected $signature = 'app:release-expired-orders';

    /**
     * Deskripsi singkat tentang perintah ini.
     */
    protected $description = 'Membatalkan pesanan yang kadaluwarsa dan mengembalikan kuota tiket.';

    /**
     * Eksekusi logika perintah.
     */
    public function handle()
    {
        // 1. Cari pesanan yang statusnya 'pending' DAN waktu expired_at sudah lewat dari waktu sekarang
        $expiredOrders = Order::with('ticketTier')
            ->where('status', 'pending')
            ->where('expired_at', '<', now())
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('Tidak ada pesanan kedaluwarsa saat ini.');
            return;
        }

        $count = 0;

        foreach ($expiredOrders as $order) {
            try {
                // Bungkus dengan transaksi agar aman
                DB::transaction(function () use ($order) {
                    // a. Kembalikan stok (capacity) ke ticket_tier
                    $tier = $order->ticketTier;
                    $tier->capacity += $order->quantity;
                    $tier->save();

                    // b. Ubah status order menjadi expired
                    $order->status = 'expired';
                    $order->save();
                });

                $count++;
            } catch (\Exception $e) {
                // Jika gagal satu, catat di log, tapi biarkan loop lanjut ke order lainnya
                Log::error("Gagal merilis order {$order->order_number}: " . $e->getMessage());
            }
        }

        $this->info("Berhasil merilis {$count} pesanan kedaluwarsa dan mengembalikan stok tiket.");
    }
}
