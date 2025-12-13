<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            PaymentMethodSeeder::class,
            AdminUserSeeder::class,
            ProductSeeder::class,
            CouponSeeder::class,
        ]);

        $this->command->info('✅ Seeders ejecutados correctamente');
        $this->command->info('📊 Datos base creados: Roles, Categorías, Marcas, Métodos de Pago, Usuarios y Productos de ejemplo');
        $this->command->info('💡 Para agregar imágenes a los productos, usa el panel de administración en /admin');
    }
}

