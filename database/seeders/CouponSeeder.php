<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        Coupon::create([
            'code' => 'BIENVENIDO10',
            'type' => 'percentage',
            'value' => 10,
            'min_purchase' => 100,
            'max_uses' => 100,
            'expires_at' => Carbon::now()->addMonths(3),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'VERANO2025',
            'type' => 'fixed',
            'value' => 50,
            'min_purchase' => 500,
            'max_uses' => 50,
            'expires_at' => Carbon::now()->addMonths(2),
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'PRIMERACOMPRA',
            'type' => 'percentage',
            'value' => 15,
            'min_purchase' => 200,
            'max_uses' => null,
            'expires_at' => null,
            'is_active' => true,
        ]);
    }
}

