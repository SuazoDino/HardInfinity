<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'order_id',
        'user_id',
        'type',
        'quantity',
        'stock_before',
        'stock_after',
        'reason',
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método estático para registrar movimiento
    public static function registrar($productId, $type, $quantity, $reason = null, $orderId = null, $userId = null)
    {
        $product = Product::findOrFail($productId);
        $stockBefore = $product->stock;
        
        // Calcular nuevo stock
        if ($type === 'entrada' || $type === 'estorno') {
            $product->stock += abs($quantity);
        } else { // salida o ajuste negativo
            $product->stock -= abs($quantity);
        }
        
        $stockAfter = $product->stock;
        $product->save();

        // Registrar movimiento
        return self::create([
            'product_id' => $productId,
            'order_id' => $orderId,
            'user_id' => $userId ?? auth()->id(),
            'type' => $type,
            'quantity' => $quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reason' => $reason,
        ]);
    }
}
