<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación: Un usuario pertenece a un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relación: Un usuario tiene muchas direcciones
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    // Relación: Un usuario tiene muchas órdenes
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Relación: Un usuario tiene muchas interacciones
    public function interactions()
    {
        return $this->hasMany(UserInteraction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }

    // Helper: Verificar si es administrador
    public function isAdmin()
    {
        return $this->role->name === 'Admin';
    }

    // Helper: Verificar si es cliente
    public function isCustomer()
    {
        return $this->role->name === 'Customer';
    }
}
