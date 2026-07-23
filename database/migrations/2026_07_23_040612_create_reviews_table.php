<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // Relasi ke User (Pembeli yang mereview)
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Relasi ke Event yang direview
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();

            // Rating 1 sampai 5
            $table->unsignedTinyInteger('rating');

            // Komentar ulasan (bisa kosong jika hanya ingin kasih bintang)
            $table->text('comment')->nullable();

            $table->timestamps();

            // Memastikan satu user hanya bisa mereview satu event sebanyak 1 kali
            $table->unique(['user_id', 'event_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
