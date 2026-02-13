<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'customer_type',
        'is_b2b_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_b2b_approved' => 'boolean',
        ];
    }

    /**
     * Get orders for this user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get wishlist items for this user
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get cart for this user
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * Get addresses for this user
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get reviews for this user
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get business profile for this user
     */
    public function businessProfile()
    {
        return $this->hasOne(BusinessProfile::class);
    }

    /**
     * Check if user is a B2B customer
     */
    public function isB2B()
    {
        return $this->customer_type === 'b2b';
    }

    /**
     * Check if B2B user is approved
     */
    public function isB2BApproved()
    {
        return $this->isB2B() && $this->is_b2b_approved;
    }

    /**
     * Get B2B orders assigned as sales rep
     */
    public function b2bOrdersAsSalesRep()
    {
        return $this->hasMany(Order::class, 'sales_rep_id');
    }
}
