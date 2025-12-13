<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $customerRole = Role::where('name', 'Customer')->first();

        // Crear usuario administrador
        User::create([
            'role_id' => $adminRole->id,
            'name' => 'Administrador',
            'email' => 'admin@hardinfinity.com',
            'password' => Hash::make('admin123'),
            'phone' => '999888777',
            'email_verified_at' => now(),
        ]);

        // Crear usuario cliente de prueba
        User::create([
            'role_id' => $customerRole->id,
            'name' => 'Cliente Prueba',
            'email' => 'cliente@hardinfinity.com',
            'password' => Hash::make('cliente123'),
            'phone' => '999888666',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ Usuarios creados:');
        $this->command->info('👤 Admin: admin@hardinfinity.com / admin123');
        $this->command->info('👤 Cliente: cliente@hardinfinity.com / cliente123');
    }
}
