<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Buyer\DashboardController as BuyerDashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentCallbackController;
use App\Http\Controllers\Tenant\EventController as TenantEventController;
use App\Http\Controllers\Tenant\ScannerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. RUTE PUBLIK (Bisa diakses siapa saja)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('events.show');

// ==========================================
// 2. RUTE GUEST (Hanya untuk yang belum login)
// ==========================================
Route::middleware('guest')->group(function () {
    Route::get('auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

// ==========================================
// 3. RUTE WEBHOOK / API BACKGROUND
// ==========================================
// Tanpa middleware auth, dan tanpa perlindungan CSRF (khusus Midtrans)
Route::post('/payments/midtrans-notification', [PaymentCallbackController::class, 'receive'])
    ->name('midtrans.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// ==========================================
// 4. RUTE PEMBELI / UMUM (Harus Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    // Dashboard Tiket Saya
    Route::get('/dashboard', [BuyerDashboardController::class, 'index'])->name('dashboard');

    // --- TAMBAHAN ROUTE REVIEW ---
    // Menyimpan ulasan dari pembeli
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Transaksi & Order
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    //csertificate
    Route::get('/orders/{order}/certificate', [\App\Http\Controllers\CertificateController::class, 'download'])->name('certificates.download');


    // Pengaturan Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==========================================
// 5. RUTE PENYELENGGARA / TENANT
// ==========================================
// Harus login DAN memiliki role 'tenant'
Route::middleware(['auth', 'role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {

    // Dashboard Tenant
    Route::get('/dashboard', [TenantEventController::class, 'index'])->name('dashboard');

    // CRUD Event
    Route::get('/events/create', [TenantEventController::class, 'create'])->name('events.create');
    Route::post('/events', [TenantEventController::class, 'store'])->name('events.store');

    // Scanner Tiket
    Route::get('/scanner', [ScannerController::class, 'index'])->name('scanner.index');
    Route::post('/scanner/verify', [ScannerController::class, 'verify'])->name('scanner.verify');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/users/{user}/role', [\App\Http\Controllers\Admin\DashboardController::class, 'updateRole'])->name('users.update-role');
});

require __DIR__ . '/auth.php';
