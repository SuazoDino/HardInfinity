<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Procesadores', 'description' => 'CPUs Intel y AMD de última generación'],
            ['name' => 'Tarjetas de Video', 'description' => 'GPUs NVIDIA y AMD para gaming y profesionales'],
            ['name' => 'Motherboards', 'description' => 'Placas madre para todas las plataformas'],
            ['name' => 'Memorias RAM', 'description' => 'Memoria DDR4 y DDR5 de alto rendimiento'],
            ['name' => 'Almacenamiento', 'description' => 'SSDs NVMe, SATA y HDDs'],
            ['name' => 'Fuentes de Poder', 'description' => 'PSUs certificadas 80 Plus'],
            ['name' => 'Gabinetes', 'description' => 'Cases ATX, Micro-ATX y Mini-ITX'],
            ['name' => 'Refrigeración', 'description' => 'Coolers AIO y disipadores de aire'],
            ['name' => 'Monitores', 'description' => 'Monitores gaming y profesionales'],
            ['name' => 'Teclados', 'description' => 'Teclados mecánicos y membrana'],
            ['name' => 'Mouses', 'description' => 'Mouses gaming y oficina'],
            ['name' => 'Audifonos', 'description' => 'Headsets gaming y profesionales'],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => \Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'is_active' => true,
                'parent_id' => null,
            ]);
        }

        $this->command->info('✅ Categorías creadas exitosamente!');
    }
}

