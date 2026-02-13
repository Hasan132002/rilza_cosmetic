<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbandonedCart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'email',
        'cart_data',
        'total_amount',
        'reminder_sent',
        'reminder_sent_at',
        'abandoned_at',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'reminder_sent' => 'boolean',
        'reminder_sent_at' => 'datetime',
        'abandoned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get carts abandoned for more than X hours
     */
    public function scopeAbandonedForHours($query, $hours = 24)
    {
        return $query->where('abandoned_at', '<=', now()->subHours($hours))
                     ->where('reminder_sent', false);
    }

    /**
     * Check if reminder should be sent
     */
    public function shouldSendReminder(): bool
    {
        return !$this->reminder_sent &&
               $this->abandoned_at &&
               $this->abandoned_at->diffInHours(now()) >= 24;
    }
}
