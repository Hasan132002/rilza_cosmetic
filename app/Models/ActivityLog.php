<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the user who performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity.
     */
    public static function log(
        string $action,
        $model,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $description = null
    ): void {
        if (!auth()->check()) {
            return;
        }

        static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => is_object($model) ? get_class($model) : $model,
            'model_id' => is_object($model) && method_exists($model, 'getKey') ? $model->getKey() : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'description' => $description,
        ]);
    }

    /**
     * Get a human-readable action name.
     */
    public function getActionNameAttribute(): string
    {
        return match ($this->action) {
            'created' => 'Created',
            'updated' => 'Updated',
            'deleted' => 'Deleted',
            'viewed' => 'Viewed',
            'restored' => 'Restored',
            'login' => 'Logged In',
            'logout' => 'Logged Out',
            default => ucfirst($this->action),
        };
    }

    /**
     * Get the model name without namespace.
     */
    public function getModelNameAttribute(): string
    {
        return class_basename($this->model_type);
    }

    /**
     * Get the action badge color.
     */
    public function getBadgeColorAttribute(): string
    {
        return match ($this->action) {
            'created' => 'green',
            'updated' => 'blue',
            'deleted' => 'red',
            'viewed' => 'gray',
            'restored' => 'purple',
            'login', 'logout' => 'yellow',
            default => 'gray',
        };
    }
}
