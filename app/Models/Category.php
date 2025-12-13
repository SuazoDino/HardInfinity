<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación: Una categoría puede tener una categoría padre
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relación: Una categoría puede tener muchas subcategorías
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relación: Una categoría tiene muchos productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope: Solo categorías activas
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: Solo categorías principales (sin padre)
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
}
