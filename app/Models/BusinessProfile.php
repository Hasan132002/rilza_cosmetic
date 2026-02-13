<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'business_registration_number',
        'tax_id_number',
        'company_address',
        'company_city',
        'company_phone',
        'company_email',
        'business_type',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'sales_rep_id',
        'admin_notes',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user that owns this business profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who approved this profile
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the sales representative assigned to this business
     */
    public function salesRep()
    {
        return $this->belongsTo(User::class, 'sales_rep_id');
    }

    /**
     * Scope to get pending profiles
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get approved profiles
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope to get rejected profiles
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if profile is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if profile is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Check if profile is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Get business type label
     */
    public function getBusinessTypeLabel()
    {
        $types = [
            'small_business' => 'Small Business',
            'distributor' => 'Distributor',
            'retailer' => 'Retailer',
            'wholesaler' => 'Wholesaler',
        ];

        return $types[$this->business_type] ?? $this->business_type;
    }
}
