<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from title when creating
        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);

                // Ensure unique slug
                $originalSlug = $page->slug;
                $count = 1;
                while (static::where('slug', $page->slug)->exists()) {
                    $page->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        // Update slug when title changes (only if slug is not manually set)
        static::updating(function ($page) {
            if ($page->isDirty('title') && !$page->isDirty('slug')) {
                $page->slug = Str::slug($page->title);

                // Ensure unique slug
                $originalSlug = $page->slug;
                $count = 1;
                while (static::where('slug', $page->slug)->where('id', '!=', $page->id)->exists()) {
                    $page->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Scope a query to only include active pages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
