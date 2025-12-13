<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'type',
    ];

    // Relación: Una interacción pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Una interacción pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper: Registrar visualización de producto
    public static function recordView($userId, $productId)
    {
        return self::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'type' => 'view',
        ]);
    }
}
