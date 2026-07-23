<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // Format: ORD-XXXXXX

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Pembeli
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ticket_tier_id')->constrained()->cascadeOnDelete();

            $table->integer('quantity');
            $table->integer('total_price');

            // Status: pending (reserve), paid (lunas), expired (waktu habis), cancelled (dibatalkan manual)
            $table->enum('status', ['pending', 'paid', 'expired', 'cancelled'])->default('pending');

            $table->string('payment_url')->nullable(); // URL Midtrans nanti
            $table->timestamp('expired_at')->nullable(); // Batas waktu bayar (15 menit)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
