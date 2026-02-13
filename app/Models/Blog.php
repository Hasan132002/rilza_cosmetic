<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author_id',
        'published_at',
        'is_published',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    // Auto generate slug from title
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);

                // Ensure unique slug
                $count = static::where('slug', 'like', $blog->slug . '%')->count();
                if ($count > 0) {
                    $blog->slug = $blog->slug . '-' . ($count + 1);
                }
            }
        });

        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);

                // Ensure unique slug
                $count = static::where('slug', 'like', $blog->slug . '%')
                              ->where('id', '!=', $blog->id)
                              ->count();
                if ($count > 0) {
                    $blog->slug = $blog->slug . '-' . ($count + 1);
                }
            }
        });
    }
}
