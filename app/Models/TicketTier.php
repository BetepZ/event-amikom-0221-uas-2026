<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketTier extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'price',
        'capacity',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'price' => 'integer',
        'capacity' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    // Tier tiket ini milik satu Event
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
