<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener categorías y marcas
        $categories = Category::all();
        $brands = Brand::all();

        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->warn('⚠️  Debes ejecutar los seeders de Categorías y Marcas primero.');
            return;
        }

        // Productos de ejemplo con especificaciones técnicas
        $products = [
            [
                'name' => 'AMD Ryzen 9 7950X 16-Core Processor',
                'sku' => 'AMD-R9-7950X',
                'description' => 'Procesador de alto rendimiento con 16 núcleos y 32 hilos, ideal para gaming extremo y workstations profesionales. Socket AM5, arquitectura Zen 4.',
                'price' => 2499.00,
                'stock' => 15,
                'category' => 'Procesadores',
                'brand' => 'AMD',
                'is_featured' => true,
                'specifications' => [
                    ['spec_name' => 'Núcleos', 'spec_value' => '16'],
                    ['spec_name' => 'Hilos', 'spec_value' => '32'],
                    ['spec_name' => 'Frecuencia Base', 'spec_value' => '4.5 GHz'],
                    ['spec_name' => 'Frecuencia Turbo', 'spec_value' => '5.7 GHz'],
                    ['spec_name' => 'Socket', 'spec_value' => 'AM5'],
                    ['spec_name' => 'Caché L3', 'spec_value' => '64 MB'],
                    ['spec_name' => 'TDP', 'spec_value' => '170W'],
                ],
            ],
            [
                'name' => 'Intel Core i9-13900K 24-Core Processor',
                'sku' => 'INTEL-I9-13900K',
                'description' => 'Procesador flagship de Intel con 24 núcleos (8P+16E) y tecnología Turbo Boost Max 3.0. Perfecto para multitarea extrema y gaming 4K.',
                'price' => 2799.00,
                'stock' => 12,
                'category' => 'Procesadores',
                'brand' => 'Intel',
                'is_featured' => true,
                'specifications' => [
                    ['spec_name' => 'Núcleos', 'spec_value' => '24 (8P + 16E)'],
                    ['spec_name' => 'Hilos', 'spec_value' => '32'],
                    ['spec_name' => 'Frecuencia Base', 'spec_value' => '3.0 GHz'],
                    ['spec_name' => 'Frecuencia Turbo', 'spec_value' => '5.8 GHz'],
                    ['spec_name' => 'Socket', 'spec_value' => 'LGA1700'],
                    ['spec_name' => 'Caché L3', 'spec_value' => '36 MB'],
                    ['spec_name' => 'TDP', 'spec_value' => '125W (253W Turbo)'],
                ],
            ],
            [
                'name' => 'NVIDIA GeForce RTX 4090 24GB GDDR6X',
                'sku' => 'NVIDIA-RTX-4090',
                'description' => 'La tarjeta gráfica más poderosa del mercado. Ray Tracing de última generación, DLSS 3.0 y 24GB de VRAM para gaming 8K y creación de contenido profesional.',
                'price' => 7999.00,
                'stock' => 8,
                'category' => 'Tarjetas de Video',
                'brand' => 'NVIDIA',
                'is_featured' => true,
                'specifications' => [
                    ['spec_name' => 'GPU', 'spec_value' => 'AD102'],
                    ['spec_name' => 'CUDA Cores', 'spec_value' => '16384'],
                    ['spec_name' => 'Memoria', 'spec_value' => '24 GB GDDR6X'],
                    ['spec_name' => 'Bus de Memoria', 'spec_value' => '384-bit'],
                    ['spec_name' => 'Clock Base', 'spec_value' => '2.23 GHz'],
                    ['spec_name' => 'Clock Boost', 'spec_value' => '2.52 GHz'],
                    ['spec_name' => 'TDP', 'spec_value' => '450W'],
                ],
            ],
            [
                'name' => 'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz',
                'sku' => 'CORSAIR-DDR5-32GB',
                'description' => 'Memoria RAM DDR5 de alto rendimiento con disipador de aluminio. Optimizada para procesadores AMD Ryzen 7000 e Intel 13th Gen.',
                'price' => 899.00,
                'stock' => 25,
                'category' => 'Memorias RAM',
                'brand' => 'Corsair',
                'is_featured' => false,
                'specifications' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '32 GB (2x16GB)'],
                    ['spec_name' => 'Tipo', 'spec_value' => 'DDR5'],
                    ['spec_name' => 'Frecuencia', 'spec_value' => '6000 MHz'],
                    ['spec_name' => 'Latencia', 'spec_value' => 'CL36'],
                    ['spec_name' => 'Voltaje', 'spec_value' => '1.35V'],
                    ['spec_name' => 'RGB', 'spec_value' => 'No'],
                ],
            ],
            [
                'name' => 'Samsung 990 PRO 2TB NVMe M.2 SSD',
                'sku' => 'SAMSUNG-990PRO-2TB',
                'description' => 'SSD NVMe PCIe 4.0 de última generación con velocidades de hasta 7,450 MB/s lectura y 6,900 MB/s escritura. Ideal para gaming y creación de contenido.',
                'price' => 799.00,
                'stock' => 30,
                'category' => 'Almacenamiento',
                'brand' => 'Samsung',
                'is_featured' => true,
                'specifications' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '2 TB'],
                    ['spec_name' => 'Factor de Forma', 'spec_value' => 'M.2 2280'],
                    ['spec_name' => 'Interfaz', 'spec_value' => 'PCIe 4.0 x4 NVMe'],
                    ['spec_name' => 'Lectura Secuencial', 'spec_value' => '7,450 MB/s'],
                    ['spec_name' => 'Escritura Secuencial', 'spec_value' => '6,900 MB/s'],
                    ['spec_name' => 'MTBF', 'spec_value' => '1.5M horas'],
                ],
            ],
        ];

        foreach ($products as $productData) {
            // Buscar categoría y marca
            $category = $categories->firstWhere('name', $productData['category']);
            $brand = $brands->firstWhere('name', $productData['brand']);

            if (!$category || !$brand) {
                continue;
            }

            // Crear producto
            $product = Product::create([
                'name' => $productData['name'],
                'sku' => $productData['sku'],
                'slug' => \Str::slug($productData['name']),
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'is_active' => true,
                'is_featured' => $productData['is_featured'],
            ]);

            // Crear imagen de placeholder
            $product->images()->create([
                'image_path' => 'https://via.placeholder.com/500x500/1a202c/0ea5e9?text=' . urlencode($product->name),
                'is_primary' => true,
                'order' => 0,
            ]);

            // Crear especificaciones
            foreach ($productData['specifications'] as $spec) {
                $product->specifications()->create($spec);
            }

            $this->command->info("✅ Producto creado: {$product->name}");
        }

        $this->command->info('🎉 Productos de ejemplo creados exitosamente!');
        $this->command->warn('💡 Para agregar imágenes, usa el panel de administración.');
    }
}

