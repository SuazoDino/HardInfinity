<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_active',
        'is_featured',
        'sku',
        'views',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected $appends = ['primary_image'];

    // Relación: Un producto pertenece a una marca
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Relación: Un producto pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: Un producto tiene muchas imágenes
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relación: Un producto tiene muchas especificaciones
    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }

    // Relación: Un producto tiene muchos items de orden
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relación: Un producto tiene muchas interacciones
    public function interactions()
    {
        return $this->hasMany(UserInteraction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Relación: Un producto tiene muchos movimientos de inventario
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    // Helper: Imagen principal
    public function primaryImage()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->where('is_primary', true)->first();
    }

    // Helper: Verificar stock disponible
    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }

    // Helper: Incrementar vistas
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Scope: Solo productos activos
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: Solo productos destacados
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope: Productos con stock disponible
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
