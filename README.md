AmikomEventHub 🎟️

AmikomEventHub adalah platform manajemen event dan ticketing modern yang dibangun untuk memenuhi kebutuhan Ujian Akhir Semester (UAS) mata kuliah Digital Bisnis. Aplikasi ini dirancang dengan arsitektur Multi-Tenant, memungkinkan berbagai pihak penyelenggara (Tenant) untuk membuat, mengelola, dan memvalidasi tiket acara mereka dalam satu pintu.

🌟 Fitur Utama

Multi-Tenant & RBAC (Role-Based Access Control):
Sistem otorisasi terpusat dengan 3 tingkatan peran pengguna:

Super Admin: Mengawasi dan mengatur hak akses seluruh pengguna di platform.

Tenant (Penyelenggara): Dapat membuat acara, mengatur kuota tiket, dan melakukan check-in pengunjung.

Pembeli: Dapat menelusuri acara, membeli tiket, dan mengunduh E-Sertifikat.

SSO Google Authentication: Registrasi dan login yang cepat dan aman menggunakan akun Google.

Dynamic Pricing & Manajemen Kuota: Penyelenggara dapat membuat berbagai tingkat tiket (misal: Early Bird, Regular) dengan harga dan kuota yang terpisah (termasuk tiket gratis).

Reserved Ticketing System: Mencegah masalah race-condition (bentrok kuota) dengan sistem pemesanan booking selama 15 menit. Jika tidak dibayar, kuota akan dikembalikan otomatis menggunakan fitur Background Scheduler.

Midtrans Payment Gateway: Integrasi pembayaran aman dan otomatis menggunakan Midtrans Snap API dan Webhook.

Sistem Check-In QR Code (Live Scanner): Penyelenggara dibekali fitur pemindai QR Code bawaan (touch-friendly) untuk memvalidasi tiket pengunjung di pintu masuk acara.

E-Sertifikat Otomatis: Pembuatan dan pengunduhan sertifikat PDF secara dinamis bagi peserta yang telah terkonfirmasi hadir (check-in).

Sistem Ulasan & Penilaian (Rating): Pengunjung yang telah menghadiri acara dapat meninggalkan ulasan untuk membantu pengunjung lain.

🚀 Teknologi yang Digunakan

Backend: Laravel (v11/12), PHP 8.2+

Frontend: Tailwind CSS (Utility-first styling), Alpine.js (Lightweight reactivity)

Database: SQLite (Lokal) / PostgreSQL/MySQL (Produksi)

Library Tambahan:

laravel/socialite (Autentikasi Google)

simplesoftwareio/simple-qrcode (Generator Tiket QR)

barryvdh/laravel-dompdf (Generator E-Sertifikat)

html5-qrcode (Scanner Kamera Pihak Ketiga)

📦 Panduan Instalasi (Lokal)

Jika Anda ingin menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut:

Kloning repositori ini:

git clone https://github.com/username-anda/amikom-event-hub.git


Masuk ke direktori proyek dan instal dependensi PHP & Node.js:

cd amikom-event-hub
composer install
npm install && npm run build


Salin file environment dan hasilkan kunci aplikasi:

cp .env.example .env
php artisan key:generate


Konfigurasikan file .env Anda, terutama untuk database, Midtrans, dan Google SSO.

Jalankan migrasi database beserta data awal (Seeder):

php artisan migrate --seed


Tautkan penyimpanan (Storage) agar gambar banner dapat diakses:

php artisan storage:link


Jalankan server lokal dan scheduler (untuk fitur expired tiket):

php artisan serve
php artisan schedule:work


Dibuat dengan 💻 untuk UAS Digital Bisnis - 2026.