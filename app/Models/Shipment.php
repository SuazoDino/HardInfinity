<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'tracking_code',
        'carrier',
        'status',
        'status_history',
        'shipped_at',
        'delivered_at',
    ];

    protected $casts = [
        'status_history' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function addStatusToHistory($status, $description = null)
    {
        $history = $this->status_history ?? [];
        $history[] = [
            'status' => $status,
            'description' => $description,
            'timestamp' => now()->toIso8601String(),
        ];
        $this->update(['status_history' => $history, 'status' => $status]);
    }
}

