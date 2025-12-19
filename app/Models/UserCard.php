<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand',
        'last_four',
        'holder_name',
        'exp_month',
        'exp_year',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
