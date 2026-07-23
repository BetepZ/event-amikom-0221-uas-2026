<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Menampilkan halaman detail event berdasarkan slug
     */
    public function show($slug)
    {
        // Ambil event berdasarkan slug, pastikan statusnya published
        // Tambahkan 'reviews.user' untuk mengambil data ulasan beserta nama pengulasnya
        $event = Event::with(['category', 'ticketTiers', 'reviews.user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail(); // Jika tidak ketemu, otomatis error 404

        return view('events.show', compact('event'));
    }
}
