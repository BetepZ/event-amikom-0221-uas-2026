<div align="center">

# 🎟️ AmikomEventHub

**Platform Manajemen Event & Ticketing Modern Berbasis Multi-Tenant**

`v24.62.0221`

[![Laravel](https://img.shields.io/badge/Laravel-11%2F12-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-utility--first-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-reactivity-8BC0D0?style=flat&logo=alpine.js&logoColor=white)](https://alpinejs.dev)

Dibuat oleh **Betano Putra Fortuna**
Proyek Ujian Akhir Semester (UAS) — Mata Kuliah Digital Bisnis

</div>

---

## 📖 Tentang Proyek

**AmikomEventHub** adalah platform manajemen event dan ticketing modern yang dibangun untuk memenuhi kebutuhan Ujian Akhir Semester (UAS) mata kuliah Digital Bisnis. Aplikasi ini dirancang dengan arsitektur **Multi-Tenant**, memungkinkan berbagai pihak penyelenggara (*Tenant*) untuk membuat, mengelola, dan memvalidasi tiket acara mereka dalam satu pintu.

---

## ✨ Fitur Utama

### 🔐 Multi-Tenant & RBAC (Role-Based Access Control)
Sistem otorisasi terpusat dengan 3 tingkatan peran pengguna:

| Peran | Deskripsi |
|---|---|
| **Super Admin** | Mengawasi dan mengatur hak akses seluruh pengguna di platform |
| **Tenant (Penyelenggara)** | Membuat acara, mengatur kuota tiket, dan melakukan check-in pengunjung |
| **Pembeli** | Menelusuri acara, membeli tiket, dan mengunduh E-Sertifikat |

### 🚀 Fitur Lainnya

- **SSO Google Authentication** — Registrasi dan login cepat & aman menggunakan akun Google
- **Dynamic Pricing & Manajemen Kuota** — Buat berbagai tingkat tiket (Early Bird, Regular, dll.) dengan harga dan kuota terpisah, termasuk tiket gratis
- **Reserved Ticketing System** — Mencegah *race condition* (bentrok kuota) dengan sistem booking selama 15 menit; kuota otomatis dikembalikan jika tidak dibayar via **Background Scheduler**
- **Midtrans Payment Gateway** — Integrasi pembayaran aman dan otomatis menggunakan Midtrans Snap API & Webhook
- **Sistem Check-In QR Code (Live Scanner)** — Fitur pemindai QR *touch-friendly* bawaan untuk validasi tiket di pintu masuk acara
- **E-Sertifikat Otomatis** — Pembuatan & pengunduhan sertifikat PDF secara dinamis bagi peserta yang telah check-in
- **Sistem Ulasan & Penilaian (Rating)** — Pengunjung yang telah menghadiri acara dapat memberi ulasan untuk membantu pengunjung lain

---

## 🛠️ Teknologi yang Digunakan

**Backend**
- Laravel (v11/12)
- PHP 8.2+

**Frontend**
- Tailwind CSS *(utility-first styling)*
- Alpine.js *(lightweight reactivity)*

**Database**
- SQLite *(lokal)*
- PostgreSQL / MySQL *(produksi)*

**Library Tambahan**

| Library | Fungsi |
|---|---|
| `laravel/socialite` | Autentikasi Google |
| `simplesoftwareio/simple-qrcode` | Generator Tiket QR |
| `barryvdh/laravel-dompdf` | Generator E-Sertifikat |
| `html5-qrcode` | Scanner Kamera Pihak Ketiga |

---

## 📦 Panduan Instalasi (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini secara lokal.

**1. Kloning repositori**

```bash
git clone https://github.com/username-anda/amikom-event-hub.git
```

**2. Masuk ke direktori proyek dan instal dependensi PHP & Node.js**

```bash
cd amikom-event-hub
composer install
npm install && npm run build
```

**3. Salin file environment dan hasilkan kunci aplikasi**

```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasikan `.env`**

Atur variabel environment untuk **database**, **Midtrans**, dan **Google SSO**.

**5. Jalankan migrasi database beserta data awal (seeder)**

```bash
php artisan migrate --seed
```

**6. Tautkan storage** agar gambar banner dapat diakses

```bash
php artisan storage:link
```

**7. Jalankan server lokal dan scheduler** (untuk fitur expired tiket)

```bash
php artisan serve
php artisan schedule:work
```

---

<div align="center">

Dibuat dengan 💻 untuk UAS Digital Bisnis — 2026

</div>