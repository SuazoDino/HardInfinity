<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'description' => 'Administrador del sistema con acceso total',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer',
                'description' => 'Cliente que puede realizar compras',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
