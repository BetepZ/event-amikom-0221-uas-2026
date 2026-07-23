<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke tabel users (Tenant)
            $table->foreignId('category_id')->constrained(); // Relasi ke kategori

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('location');
            $table->date('event_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('banner_image')->nullable();

            // Opsi e-sertifikat yang diaktifkan tenant
            $table->boolean('is_certificate_enabled')->default(false);

            $table->enum('status', ['draft', 'published', 'finished'])->default('draft');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
