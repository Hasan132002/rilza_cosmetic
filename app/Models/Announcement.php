<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'message',
        'link_url',
        'link_text',
        'background_color',
        'text_color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope: Get only active announcements
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
