<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Order; // Tambahkan ini untuk mengecek pesanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Menampilkan Dashboard Tenant (Daftar Event yang dimiliki)
     */
    public function index()
    {
        // Mengambil event milik tenant yang sedang login
        $events = Event::where('user_id', Auth::id())->latest()->get();

        return view('tenant.dashboard', compact('events'));
    }

    /**
     * Menampilkan form pembuatan Event baru
     */
    public function create()
    {
        // Mengambil semua kategori untuk ditampilkan di dropdown form
        $categories = Category::all();

        return view('tenant.events.create', compact('categories'));
    }

    /**
     * Menyimpan data Event baru ke database
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            // Validasi array jenis tiket (Alpine.js)
            'tiers' => 'required|array|min:1',
            'tiers.*.name' => 'required|string|max:255',
            'tiers.*.price' => 'required|numeric|min:0',
            'tiers.*.capacity' => 'required|numeric|min:1',
        ]);

        try {
            // Memulai Transaksi Database
            DB::beginTransaction();

            // 2. Proses Upload Banner (Jika Ada)
            $bannerPath = null;
            if ($request->hasFile('banner_image')) {
                // Simpan ke folder storage/app/public/event-banners
                $bannerPath = $request->file('banner_image')->store('event-banners', 'public');
            }

            // 3. Generate Slug Unik
            $slug = Str::slug($request->title . '-' . time());

            // 4. Simpan Data Event
            /** @var \App\Models\User $user */
            $user = Auth::user();

            $event = $user->events()->create([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'location' => $request->location,
                'event_date' => $request->event_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'banner_image' => $bannerPath,
                'is_certificate_enabled' => $request->has('is_certificate_enabled'),
                'status' => 'published', // Langsung dipublish agar mudah dites
            ]);

            // 5. Simpan Jenis Tiket (Ticket Tiers)
            foreach ($request->tiers as $tier) {
                $event->ticketTiers()->create([
                    'name' => $tier['name'],
                    'price' => $tier['price'],
                    'capacity' => $tier['capacity'],
                ]);
            }

            // Jika semua berhasil, permanenkan data
            DB::commit();

            return redirect()->route('tenant.dashboard')->with('success', 'Event berhasil dibuat dan diterbitkan!');
        } catch (\Exception $e) {
            // Jika terjadi kegagalan (Rollback)
            DB::rollBack();

            // Hapus gambar jika telanjur terupload namun simpan database gagal
            if (isset($bannerPath)) {
                Storage::disk('public')->delete($bannerPath);
            }

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }

    /**
     * Menampilkan form edit Event
     */
    public function edit(Event $event)
    {
        // Proteksi Otorisasi
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengakses event ini.');
        }

        $categories = Category::all();
        return view('tenant.events.edit', compact('event', 'categories'));
    }

    /**
     * Menyimpan perubahan data Event
     */
    public function update(Request $request, Event $event)
    {
        // Proteksi Otorisasi
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengubah event ini.');
        }

        // Validasi input (Kita abaikan edit struktur harga tiket agar histori aman)
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $bannerPath = $event->banner_image;

            // Jika ada upload banner baru
            if ($request->hasFile('banner_image')) {
                // Hapus gambar lama dari server jika ada
                if ($bannerPath && Storage::disk('public')->exists($bannerPath)) {
                    Storage::disk('public')->delete($bannerPath);
                }
                $bannerPath = $request->file('banner_image')->store('event-banners', 'public');
            }

            // Update data (Slug tidak diubah agar link yang sudah tersebar tidak mati/error 404)
            $event->update([
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'event_date' => $request->event_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'banner_image' => $bannerPath,
                'is_certificate_enabled' => $request->has('is_certificate_enabled'),
            ]);

            DB::commit();

            return redirect()->route('tenant.dashboard')->with('success', 'Detail Event berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal memperbarui: ' . $e->getMessage()]);
        }
    }

    /**
     * Menghapus Event (Soft Delete Manual) dengan proteksi ketat
     */
    public function destroy(Event $event)
    {
        // Proteksi Otorisasi
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus event ini.');
        }

        // PROTEKSI UTAMA: Cek apakah sudah ada pesanan/pembeli
        $hasOrders = Order::where('event_id', $event->id)->exists();

        if ($hasOrders) {
            return back()->with('error', 'GAGAL: Event ini tidak dapat dihapus karena sudah ada pengunjung yang membeli tiket. Sistem melindungi uang dan histori pesanan mereka.');
        }

        // Jika aman (0 pembeli), hapus gambar fisiknya juga
        if ($event->banner_image && Storage::disk('public')->exists($event->banner_image)) {
            Storage::disk('public')->delete($event->banner_image);
        }

        $event->delete();

        return redirect()->route('tenant.dashboard')->with('success', 'Event berhasil dihapus secara permanen.');
    }
}
