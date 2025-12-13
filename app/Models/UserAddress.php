<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_line',
        'city',
        'state',
        'zip_code',
        'country',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Relación: Una dirección pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
