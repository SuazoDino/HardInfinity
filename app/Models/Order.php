<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'tax',
        'shipping_cost',
        'discount',
        'coupon_code',
        'total_amount',
        'payment_method',
        'payment_status',
        'shipping_address',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    // Relación: Una orden pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una orden tiene muchos items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relación: Una orden tiene muchas transacciones
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relación: Una orden tiene un envío
    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }

    // Helper: Generar número de orden único
    public static function generateOrderNumber()
    {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    // Scope: Órdenes por estado
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
