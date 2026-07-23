<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Memproses dan mengunduh E-Sertifikat
     */
    public function download(Order $order)
    {
        // 1. Keamanan: Pastikan hanya pemilik tiket yang bisa unduh
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        $event = $order->event;

        // 2. Validasi: Apakah event ini mengaktifkan fitur sertifikat?
        if (!$event->is_certificate_enabled) {
            abort(404, 'Sertifikat tidak tersedia untuk acara ini.');
        }

        // 3. Validasi: Apakah pembeli benar-benar HADIR (tiket di-scan)?
        $hasAttended = $order->tickets()->where('status', 'used')->exists();
        if (!$hasAttended) {
            abort(403, 'Sertifikat hanya diberikan kepada peserta yang hadir (check-in).');
        }

        // 4. Validasi: Apakah acara sudah selesai? (Gabungkan tanggal dan jam akhir)
        $eventEndDateTime = Carbon::parse($event->event_date->format('Y-m-d') . ' ' . $event->end_time);

        if (now()->lessThan($eventEndDateTime)) {
            abort(403, 'Sertifikat baru bisa diunduh setelah acara selesai pada ' . $eventEndDateTime->format('d M Y, H:i'));
        }

        // 5. Generate PDF menggunakan tampilan blade 'certificates.template'
        $pdf = Pdf::loadView('certificates.template', [
            'buyerName' => $order->user->name,
            'eventTitle' => $event->title,
            'eventDate' => $event->event_date->format('d F Y'),
            'organizer' => $event->user->name,
        ])->setPaper('a4', 'landscape'); // Format A4 Mendatar (Lanskap)

        // 6. Unduh file dengan nama yang rapi
        $fileName = 'Sertifikat-' . Str::slug($event->title) . '.pdf';
        return $pdf->download($fileName);
    }
}
