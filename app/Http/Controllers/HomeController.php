<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan Landing Page (Katalog Event)
     */
    public function index()
    {
        // Mengambil event yang sudah di-publish, urut dari yang terbaru
        // Kita juga memuat relasi (with) 'category' untuk mencegah N+1 Query
        $events = Event::with('category')
            ->where('status', 'published')
            ->latest()
            ->get();

        return view('home', compact('events'));
    }
}
