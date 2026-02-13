<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'is_subscribed',
        'subscribed_at',
    ];

    protected $casts = [
        'is_subscribed' => 'boolean',
        'subscribed_at' => 'datetime',
    ];

    /**
     * Validation rules
     */
    public static function rules($method = 'store')
    {
        return [
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ];
    }
}
