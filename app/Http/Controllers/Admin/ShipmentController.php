<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'tracking_code' => 'nullable|string|max:255',
            'carrier' => 'nullable|string|max:255',
            'status' => 'required|in:preparing,shipped,in_transit,delivered',
        ]);

        $shipment = $order->shipment;

        if (!$shipment) {
            $shipment = Shipment::create([
                'order_id' => $order->id,
                'tracking_code' => $validated['tracking_code'] ?? null,
                'carrier' => $validated['carrier'] ?? null,
                'status' => $validated['status'],
                'status_history' => [[
                    'status' => $validated['status'],
                    'description' => 'Estado inicial',
                    'timestamp' => now()->toIso8601String(),
                ]],
            ]);
        } else {
            $shipment->update([
                'tracking_code' => $validated['tracking_code'] ?? $shipment->tracking_code,
                'carrier' => $validated['carrier'] ?? $shipment->carrier,
            ]);
            $shipment->addStatusToHistory($validated['status']);
        }

        if ($validated['status'] === 'shipped' && !$shipment->shipped_at) {
            $shipment->update(['shipped_at' => now()]);
        }
        if ($validated['status'] === 'delivered' && !$shipment->delivered_at) {
            $shipment->update(['delivered_at' => now()]);
            $order->update(['status' => 'delivered']);
        }

        return back()->with('success', 'Envío actualizado.');
    }
}

