<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function validateCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->code))->first();

        if (!$coupon) {
            return response()->json(['error' => 'Cupón no encontrado'], 404);
        }

        if (!$coupon->isValid($request->subtotal)) {
            $reasons = [];
            if (!$coupon->is_active) $reasons[] = 'Cupón inactivo';
            if ($coupon->expires_at && $coupon->expires_at->isPast()) $reasons[] = 'Cupón expirado';
            if ($coupon->max_uses && $coupon->uses_count >= $coupon->max_uses) $reasons[] = 'Límite alcanzado';
            if ($request->subtotal < $coupon->min_purchase) $reasons[] = 'Compra mínima: S/ ' . $coupon->min_purchase;

            return response()->json(['error' => implode('. ', $reasons)], 422);
        }

        $discount = $coupon->calculateDiscount($request->subtotal);

        return response()->json([
            'success' => true,
            'coupon' => [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'discount' => $discount,
            ],
            'message' => '¡Cupón aplicado! Ahorras S/ ' . number_format($discount, 2),
        ]);
    }
}

