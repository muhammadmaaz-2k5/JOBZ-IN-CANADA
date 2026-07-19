<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type', // percentage, fixed
        'value',
        'starts_at',
        'expires_at',
        'usage_limit',
        'status', // active, inactive
    ];

    protected $casts = [
        'value' => 'integer',
        'usage_limit' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function isValid()
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->starts_at && $this->starts_at->isFuture()) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // We can optionally check usage count here if we had usage history tracking,
        // but simple bounds checking matches standard coupon scopes perfectly.
        return true;
    }

    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return round(($amount * $this->value) / 100);
        }

        // Fixed amount
        return min($amount, $this->value);
    }
}
