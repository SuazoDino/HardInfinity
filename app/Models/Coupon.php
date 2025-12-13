<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'max_uses',
        'uses_count',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function isValid($subtotal = 0)
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->max_uses && $this->uses_count >= $this->max_uses) return false;
        if ($subtotal < $this->min_purchase) return false;
        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if ($this->type === 'percentage') {
            return ($subtotal * $this->value) / 100;
        }
        return min($this->value, $subtotal);
    }

    public function incrementUse()
    {
        $this->increment('uses_count');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }
}

