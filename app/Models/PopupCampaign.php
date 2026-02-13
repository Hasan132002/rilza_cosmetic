<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopupCampaign extends Model
{
    protected $fillable = [
        'name',
        'type',
        'title',
        'description',
        'button_text',
        'button_link',
        'image',
        'coupon_code',
        'delay_seconds',
        'show_on_exit',
        'is_active',
        'display_frequency',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_on_exit' => 'boolean',
        'delay_seconds' => 'integer',
        'display_frequency' => 'integer',
    ];

    /**
     * Scope to get active popups
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
