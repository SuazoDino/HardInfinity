<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'NVIDIA',
            'AMD',
            'Intel',
            'Corsair',
            'Kingston',
            'Seagate',
            'Western Digital',
            'ASUS',
            'MSI',
            'Gigabyte',
            'Logitech',
            'Razer',
            'HyperX',
            'Cooler Master',
            'NZXT',
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->insert([
                'name' => $brand,
                'slug' => Str::slug($brand),
                'logo_url' => '/images/brands/' . Str::slug($brand) . '.png',
                'description' => 'Marca líder en tecnología',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
