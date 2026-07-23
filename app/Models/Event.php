<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'location',
        'event_date',
        'start_time',
        'end_time',
        'banner_image',
        'is_certificate_enabled',
        'status'
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_certificate_enabled' => 'boolean',
    ];

    // Event dimiliki oleh satu User (Tenant)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Event masuk dalam satu Kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Event memiliki banyak jenis tiket (Dynamic Pricing)
    public function ticketTiers(): HasMany
    {
        return $this->hasMany(TicketTier::class);
    }

    // --- TAMBAHAN RELASI REVIEW ---
    // Event memiliki banyak ulasan
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
