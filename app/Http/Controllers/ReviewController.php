<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Menyimpan ulasan baru dari pembeli
     */
    public function store(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();
        $eventId = $request->event_id;

        // 2. Keamanan: Cek apakah user pernah beli tiket event ini dan tiketnya SUDAH DIPAKAI (Hadir)
        $hasAttended = Order::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->whereHas('tickets', function ($query) {
                // Tiket harus berstatus 'used' (sudah di-scan panitia)
                $query->where('status', 'used');
            })
            ->exists();

        if (!$hasAttended) {
            return back()->with('error', 'Anda hanya dapat mengulas event yang telah Anda hadiri (tiket sudah di-scan).');
        }

        // 3. Keamanan: Cek apakah user sudah pernah mereview event ini sebelumnya
        $existingReview = Review::where('user_id', $userId)
            ->where('event_id', $eventId)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk event ini.');
        }

        // 4. Simpan Ulasan ke Database
        Review::create([
            'user_id' => $userId,
            'event_id' => $eventId,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
