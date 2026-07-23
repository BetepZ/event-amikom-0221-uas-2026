<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $serverKey = config('midtrans.server_key');

        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;
        $transactionStatus = $request->transaction_status;
        $fraudStatus = $request->fraud_status;

        // 1. Verifikasi Keamanan Signature Key (Wajib!)
        // Rumus Midtrans: SHA512(order_id + status_code + gross_amount + server_key)
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($expectedSignature !== $signatureKey) {
            Log::error("Midtrans Webhook: Invalid Signature Key for Order {$orderId}");
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // 2. Cari Pesanan di Database
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::error("Midtrans Webhook: Order {$orderId} not found.");
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Jika pesanan sudah berstatus 'paid' atau 'expired', abaikan saja
        // Mencegah tiket ter-generate dua kali (Race Condition webhook vs redirect JS)
        if ($order->status === 'paid' || $order->status === 'expired') {
            return response()->json(['message' => 'Order already processed']);
        }

        // 3. Evaluasi Status Pembayaran
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                $this->processSuccess($order);
            }
        } elseif ($transactionStatus == 'settlement') {
            // Ini untuk pembayaran non-kartu kredit (seperti Gopay, VA, QRIS)
            $this->processSuccess($order);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            // Pembayaran gagal atau kadaluwarsa dari sisi Midtrans
            $this->processFailed($order);
        }

        return response()->json(['message' => 'Callback processed']);
    }

    /**
     * Memproses pesanan yang sukses dibayar
     */
    private function processSuccess(Order $order)
    {
        $order->update(['status' => 'paid']);

        // Generate tiket fisik/QR Code sebanyak jumlah pesanan
        for ($i = 0; $i < $order->quantity; $i++) {
            Ticket::create([
                'order_id' => $order->id,
                'ticket_code' => 'TKT-' . strtoupper(Str::random(10)),
                'status' => 'valid'
            ]);
        }
    }

    /**
     * Memproses pesanan yang gagal/kadaluwarsa
     */
    private function processFailed(Order $order)
    {
        // Ubah status dan kembalikan stok
        $order->update(['status' => 'expired']);

        $tier = $order->ticketTier;
        $tier->capacity += $order->quantity;
        $tier->save();
    }
}
