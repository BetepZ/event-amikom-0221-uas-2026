<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            $table->string('ticket_code')->unique(); // Kode unik untuk di-generate jadi QR Code

            // Status: valid (bisa dipakai), used (sudah di-scan panitia)
            $table->enum('status', ['valid', 'used'])->default('valid');

            $table->timestamp('scanned_at')->nullable(); // Waktu check-in

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
