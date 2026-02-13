<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'old_quantity',
        'new_quantity',
        'quantity_changed',
        'action',
        'reason',
        'notes',
    ];

    /**
     * Relationships
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log inventory change
     */
    public static function logChange($productId, $oldQuantity, $newQuantity, $action, $reason = null, $notes = null)
    {
        $quantityChanged = $newQuantity - $oldQuantity;

        return self::create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'old_quantity' => $oldQuantity,
            'new_quantity' => $newQuantity,
            'quantity_changed' => $quantityChanged,
            'action' => $action,
            'reason' => $reason,
            'notes' => $notes,
        ]);
    }
}
