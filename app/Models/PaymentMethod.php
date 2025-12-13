<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación: Un método de pago tiene muchas transacciones
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Scope: Solo métodos activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
