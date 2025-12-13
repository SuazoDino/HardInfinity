<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'transaction_code',
        'status',
        'amount',
        'details',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // Relación: Una transacción pertenece a una orden
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación: Una transacción pertenece a un método de pago
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
