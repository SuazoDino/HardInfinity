<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductosRealesSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            // ===== PROCESADORES AMD =====
            [
                'nombre' => 'AMD Ryzen 9 7950X3D',
                'sku' => 'AMD-7950X3D',
                'descripcion' => 'Procesador de gaming premium con tecnología 3D V-Cache. 16 núcleos, 32 hilos, ideal para gaming extremo y creación de contenido.',
                'precio' => 2899.00,
                'stock' => 10,
                'categoria' => 'Procesadores',
                'marca' => 'AMD',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '16/32'],
                    ['spec_name' => 'Frecuencia Base', 'spec_value' => '4.2 GHz'],
                    ['spec_name' => 'Frecuencia Boost', 'spec_value' => '5.7 GHz'],
                    ['spec_name' => 'Cache', 'spec_value' => '128MB L3'],
                    ['spec_name' => 'TDP', 'spec_value' => '120W'],
                ]
            ],
            [
                'nombre' => 'AMD Ryzen 9 7950X',
                'sku' => 'AMD-7950X',
                'descripcion' => 'Procesador de 16 núcleos y 32 hilos con arquitectura Zen 4. Excelente para workstations y gaming.',
                'precio' => 2499.00,
                'stock' => 15,
                'categoria' => 'Procesadores',
                'marca' => 'AMD',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '16/32'],
                    ['spec_name' => 'Frecuencia Base', 'spec_value' => '4.5 GHz'],
                    ['spec_name' => 'Frecuencia Boost', 'spec_value' => '5.7 GHz'],
                ]
            ],
            [
                'nombre' => 'AMD Ryzen 7 7800X3D',
                'sku' => 'AMD-7800X3D',
                'descripcion' => 'El mejor procesador para gaming puro. 8 núcleos con 3D V-Cache para máximo rendimiento en juegos.',
                'precio' => 1899.00,
                'stock' => 20,
                'categoria' => 'Procesadores',
                'marca' => 'AMD',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '8/16'],
                    ['spec_name' => 'Frecuencia Base', 'spec_value' => '4.0 GHz'],
                    ['spec_name' => 'Cache', 'spec_value' => '96MB L3'],
                ]
            ],
            [
                'nombre' => 'AMD Ryzen 5 7600X',
                'sku' => 'AMD-7600X',
                'descripcion' => 'Procesador gaming de gama media-alta. 6 núcleos, excelente rendimiento precio-calidad.',
                'precio' => 1199.00,
                'stock' => 30,
                'categoria' => 'Procesadores',
                'marca' => 'AMD',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '6/12'],
                    ['spec_name' => 'Frecuencia Base', 'spec_value' => '4.7 GHz'],
                ]
            ],

            // ===== PROCESADORES INTEL =====
            [
                'nombre' => 'Intel Core i9-13900K',
                'sku' => 'INTEL-13900K',
                'descripcion' => 'Procesador flagship de Intel con 24 núcleos (8P+16E). Máximo rendimiento en gaming y productividad.',
                'precio' => 2799.00,
                'stock' => 12,
                'categoria' => 'Procesadores',
                'marca' => 'Intel',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '24/32 (8P+16E)'],
                    ['spec_name' => 'Frecuencia Turbo', 'spec_value' => '5.8 GHz'],
                    ['spec_name' => 'Socket', 'spec_value' => 'LGA1700'],
                ]
            ],
            [
                'nombre' => 'Intel Core i7-13700K',
                'sku' => 'INTEL-13700K',
                'descripcion' => 'Procesador de 16 núcleos perfecto para gaming y streaming simultáneo.',
                'precio' => 1999.00,
                'stock' => 18,
                'categoria' => 'Procesadores',
                'marca' => 'Intel',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '16/24 (8P+8E)'],
                    ['spec_name' => 'Frecuencia Turbo', 'spec_value' => '5.4 GHz'],
                ]
            ],
            [
                'nombre' => 'Intel Core i5-13600K',
                'sku' => 'INTEL-13600K',
                'descripcion' => 'Procesador gaming de gama media-alta. 14 núcleos con excelente relación rendimiento-precio.',
                'precio' => 1499.00,
                'stock' => 25,
                'categoria' => 'Procesadores',
                'marca' => 'Intel',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '14/20 (6P+8E)'],
                    ['spec_name' => 'Frecuencia Turbo', 'spec_value' => '5.1 GHz'],
                ]
            ],

            // ===== TARJETAS DE VIDEO NVIDIA =====
            [
                'nombre' => 'NVIDIA GeForce RTX 4090 24GB',
                'sku' => 'NVIDIA-RTX4090',
                'descripcion' => 'La GPU más potente del mercado. Ray Tracing, DLSS 3, 24GB VRAM. Para gaming 4K/8K y creación profesional.',
                'precio' => 7999.00,
                'stock' => 8,
                'categoria' => 'Tarjetas de Video',
                'marca' => 'NVIDIA',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'CUDA Cores', 'spec_value' => '16384'],
                    ['spec_name' => 'Memoria', 'spec_value' => '24GB GDDR6X'],
                    ['spec_name' => 'Bus', 'spec_value' => '384-bit'],
                    ['spec_name' => 'TDP', 'spec_value' => '450W'],
                ]
            ],
            [
                'nombre' => 'NVIDIA GeForce RTX 4080 16GB',
                'sku' => 'NVIDIA-RTX4080',
                'descripcion' => 'GPU de alto rendimiento para gaming 4K y ray tracing avanzado.',
                'precio' => 5499.00,
                'stock' => 15,
                'categoria' => 'Tarjetas de Video',
                'marca' => 'NVIDIA',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'CUDA Cores', 'spec_value' => '9728'],
                    ['spec_name' => 'Memoria', 'spec_value' => '16GB GDDR6X'],
                    ['spec_name' => 'TDP', 'spec_value' => '320W'],
                ]
            ],
            [
                'nombre' => 'NVIDIA GeForce RTX 4070 Ti 12GB',
                'sku' => 'NVIDIA-RTX4070TI',
                'descripcion' => 'Tarjeta gráfica de gama alta para gaming 1440p y 4K.',
                'precio' => 3999.00,
                'stock' => 20,
                'categoria' => 'Tarjetas de Video',
                'marca' => 'NVIDIA',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'CUDA Cores', 'spec_value' => '7680'],
                    ['spec_name' => 'Memoria', 'spec_value' => '12GB GDDR6X'],
                ]
            ],
            [
                'nombre' => 'NVIDIA GeForce RTX 4060 Ti 8GB',
                'sku' => 'NVIDIA-RTX4060TI',
                'descripcion' => 'GPU de gama media para gaming 1080p/1440p con DLSS 3.',
                'precio' => 2199.00,
                'stock' => 35,
                'categoria' => 'Tarjetas de Video',
                'marca' => 'NVIDIA',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Memoria', 'spec_value' => '8GB GDDR6'],
                    ['spec_name' => 'TDP', 'spec_value' => '160W'],
                ]
            ],

            // ===== MEMORIAS RAM CORSAIR =====
            [
                'nombre' => 'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz',
                'sku' => 'CORSAIR-DDR5-32GB-6000',
                'descripcion' => 'Memoria DDR5 de alto rendimiento con disipador de aluminio. Compatible AMD Ryzen 7000 e Intel 13th Gen.',
                'precio' => 899.00,
                'stock' => 40,
                'categoria' => 'Memorias RAM',
                'marca' => 'Corsair',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '32GB (2x16GB)'],
                    ['spec_name' => 'Frecuencia', 'spec_value' => '6000MHz'],
                    ['spec_name' => 'Latencia', 'spec_value' => 'CL36'],
                ]
            ],
            [
                'nombre' => 'Corsair Vengeance RGB DDR5 64GB (2x32GB) 5600MHz',
                'sku' => 'CORSAIR-DDR5-64GB-RGB',
                'descripcion' => 'Memoria DDR5 con iluminación RGB programable. Ideal para workstations y gaming extremo.',
                'precio' => 1599.00,
                'stock' => 25,
                'categoria' => 'Memorias RAM',
                'marca' => 'Corsair',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '64GB (2x32GB)'],
                    ['spec_name' => 'RGB', 'spec_value' => 'Sí - iCUE'],
                ]
            ],
            [
                'nombre' => 'Corsair Dominator Platinum DDR5 32GB 6200MHz',
                'sku' => 'CORSAIR-DOMINATOR-32GB',
                'descripcion' => 'Memoria premium con módulo DHEX para máxima refrigeración y overclock.',
                'precio' => 1299.00,
                'stock' => 15,
                'categoria' => 'Memorias RAM',
                'marca' => 'Corsair',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '32GB'],
                    ['spec_name' => 'Frecuencia', 'spec_value' => '6200MHz'],
                ]
            ],

            // ===== MEMORIAS RAM KINGSTON =====
            [
                'nombre' => 'Kingston Fury Beast DDR5 32GB (2x16GB) 5600MHz',
                'sku' => 'KINGSTON-FURY-DDR5-32GB',
                'descripcion' => 'Memoria DDR5 gaming con disipador de bajo perfil. Plug N Play.',
                'precio' => 799.00,
                'stock' => 50,
                'categoria' => 'Memorias RAM',
                'marca' => 'Kingston',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '32GB (2x16GB)'],
                    ['spec_name' => 'Frecuencia', 'spec_value' => '5600MHz'],
                ]
            ],
            [
                'nombre' => 'Kingston Fury Renegade DDR5 64GB (2x32GB) 6400MHz',
                'sku' => 'KINGSTON-RENEGADE-64GB',
                'descripcion' => 'Memoria DDR5 de alto rendimiento certificada para overclock.',
                'precio' => 1699.00,
                'stock' => 20,
                'categoria' => 'Memorias RAM',
                'marca' => 'Kingston',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '64GB'],
                    ['spec_name' => 'Frecuencia', 'spec_value' => '6400MHz'],
                ]
            ],

            // ===== ALMACENAMIENTO WESTERN DIGITAL =====
            [
                'nombre' => 'Western Digital Black SN850X 2TB NVMe',
                'sku' => 'WD-SN850X-2TB',
                'descripcion' => 'SSD NVMe Gen4 optimizado para gaming. Velocidades hasta 7,300 MB/s.',
                'precio' => 899.00,
                'stock' => 35,
                'categoria' => 'Almacenamiento',
                'marca' => 'Western Digital',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '2TB'],
                    ['spec_name' => 'Interfaz', 'spec_value' => 'PCIe 4.0 x4'],
                    ['spec_name' => 'Lectura', 'spec_value' => '7,300 MB/s'],
                ]
            ],
            [
                'nombre' => 'Western Digital Blue 1TB SSD SATA',
                'sku' => 'WD-BLUE-1TB',
                'descripcion' => 'SSD SATA económico y confiable para upgrade de PCs.',
                'precio' => 299.00,
                'stock' => 60,
                'categoria' => 'Almacenamiento',
                'marca' => 'Western Digital',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '1TB'],
                    ['spec_name' => 'Interfaz', 'spec_value' => 'SATA III'],
                ]
            ],

            // ===== ALMACENAMIENTO SEAGATE =====
            [
                'nombre' => 'Seagate FireCuda 530 2TB NVMe Gen4',
                'sku' => 'SEAGATE-FIRECUDA-2TB',
                'descripcion' => 'SSD NVMe de alto rendimiento con disipador incluido. Ideal para gaming y edición de video.',
                'precio' => 949.00,
                'stock' => 25,
                'categoria' => 'Almacenamiento',
                'marca' => 'Seagate',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '2TB'],
                    ['spec_name' => 'Lectura', 'spec_value' => '7,300 MB/s'],
                    ['spec_name' => 'Escritura', 'spec_value' => '6,900 MB/s'],
                ]
            ],
            [
                'nombre' => 'Seagate BarraCuda 2TB HDD 7200RPM',
                'sku' => 'SEAGATE-BARRACUDA-2TB',
                'descripcion' => 'Disco duro mecánico de 2TB para almacenamiento masivo.',
                'precio' => 249.00,
                'stock' => 80,
                'categoria' => 'Almacenamiento',
                'marca' => 'Seagate',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '2TB'],
                    ['spec_name' => 'RPM', 'spec_value' => '7200'],
                ]
            ],

            // ===== PLACAS MADRE ASUS =====
            [
                'nombre' => 'ASUS ROG Strix X670E-E Gaming WiFi',
                'sku' => 'ASUS-X670E-STRIX',
                'descripcion' => 'Placa madre premium para AMD Ryzen 7000. PCIe 5.0, DDR5, WiFi 6E.',
                'precio' => 2299.00,
                'stock' => 12,
                'categoria' => 'Placas Madre',
                'marca' => 'ASUS',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Socket', 'spec_value' => 'AM5'],
                    ['spec_name' => 'Chipset', 'spec_value' => 'X670E'],
                    ['spec_name' => 'Memoria', 'spec_value' => 'DDR5 hasta 128GB'],
                ]
            ],
            [
                'nombre' => 'ASUS TUF Gaming Z790-Plus WiFi',
                'sku' => 'ASUS-Z790-TUF',
                'descripcion' => 'Placa madre gaming para Intel 13th Gen con componentes militares TUF.',
                'precio' => 1799.00,
                'stock' => 18,
                'categoria' => 'Placas Madre',
                'marca' => 'ASUS',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Socket', 'spec_value' => 'LGA1700'],
                    ['spec_name' => 'Chipset', 'spec_value' => 'Z790'],
                ]
            ],
            [
                'nombre' => 'ASUS ROG Maximus Z790 Hero',
                'sku' => 'ASUS-Z790-HERO',
                'descripcion' => 'Placa madre extreme para overclock y gaming de alto nivel.',
                'precio' => 3299.00,
                'stock' => 8,
                'categoria' => 'Placas Madre',
                'marca' => 'ASUS',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Socket', 'spec_value' => 'LGA1700'],
                    ['spec_name' => 'PCIe 5.0', 'spec_value' => 'Sí'],
                ]
            ],

            // ===== PERIFÉRICOS RAZER =====
            [
                'nombre' => 'Razer DeathAdder V3 Pro',
                'sku' => 'RAZER-DEATHADDER-V3',
                'descripcion' => 'Mouse gaming inalámbrico con sensor Focus Pro 30K. 90 horas de batería.',
                'precio' => 599.00,
                'stock' => 45,
                'categoria' => 'Periféricos',
                'marca' => 'Razer',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'DPI', 'spec_value' => '30,000'],
                    ['spec_name' => 'Conectividad', 'spec_value' => 'Wireless + Bluetooth'],
                    ['spec_name' => 'Peso', 'spec_value' => '63g'],
                ]
            ],
            [
                'nombre' => 'Razer BlackWidow V4 Pro',
                'sku' => 'RAZER-BLACKWIDOW-V4',
                'descripcion' => 'Teclado mecánico gaming con switches Green, dial multifunción y RGB Chroma.',
                'precio' => 899.00,
                'stock' => 30,
                'categoria' => 'Periféricos',
                'marca' => 'Razer',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Switches', 'spec_value' => 'Razer Green (Clicky)'],
                    ['spec_name' => 'RGB', 'spec_value' => 'Chroma RGB'],
                ]
            ],
            [
                'nombre' => 'Razer Kraken V3 Pro',
                'sku' => 'RAZER-KRAKEN-V3',
                'descripcion' => 'Audífonos gaming wireless con Haptic Feedback y THX Spatial Audio.',
                'precio' => 799.00,
                'stock' => 25,
                'categoria' => 'Periféricos',
                'marca' => 'Razer',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Driver', 'spec_value' => '50mm TriForce'],
                    ['spec_name' => 'Batería', 'spec_value' => '28 horas'],
                ]
            ],

            // ===== MÁS PRODUCTOS NVIDIA =====
            [
                'nombre' => 'NVIDIA GeForce RTX 4070 12GB',
                'sku' => 'NVIDIA-RTX4070',
                'descripcion' => 'GPU ideal para gaming 1440p con ray tracing y DLSS 3.',
                'precio' => 2999.00,
                'stock' => 28,
                'categoria' => 'Tarjetas de Video',
                'marca' => 'NVIDIA',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Memoria', 'spec_value' => '12GB GDDR6X'],
                    ['spec_name' => 'TDP', 'spec_value' => '200W'],
                ]
            ],
            [
                'nombre' => 'NVIDIA GeForce RTX 4060 8GB',
                'sku' => 'NVIDIA-RTX4060',
                'descripcion' => 'GPU de entrada para gaming 1080p con tecnologías modernas.',
                'precio' => 1799.00,
                'stock' => 50,
                'categoria' => 'Tarjetas de Video',
                'marca' => 'NVIDIA',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Memoria', 'spec_value' => '8GB GDDR6'],
                ]
            ],

            // ===== MÁS PRODUCTOS INTEL =====
            [
                'nombre' => 'Intel Core i9-14900K',
                'sku' => 'INTEL-14900K',
                'descripcion' => 'Procesador Intel de 14ta generación con 24 núcleos. Máximo rendimiento.',
                'precio' => 3199.00,
                'stock' => 10,
                'categoria' => 'Procesadores',
                'marca' => 'Intel',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '24/32'],
                    ['spec_name' => 'Frecuencia Turbo', 'spec_value' => '6.0 GHz'],
                ]
            ],
            [
                'nombre' => 'Intel Core i7-14700K',
                'sku' => 'INTEL-14700K',
                'descripcion' => 'Procesador gaming de 14ta generación con 20 núcleos.',
                'precio' => 2299.00,
                'stock' => 15,
                'categoria' => 'Procesadores',
                'marca' => 'Intel',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '20/28'],
                ]
            ],

            // ===== PERIFÉRICOS CORSAIR =====
            [
                'nombre' => 'Corsair K70 RGB Pro Mechanical Gaming Keyboard',
                'sku' => 'CORSAIR-K70-RGB',
                'descripcion' => 'Teclado mecánico gaming con switches Cherry MX y RGB dinámico.',
                'precio' => 699.00,
                'stock' => 35,
                'categoria' => 'Periféricos',
                'marca' => 'Corsair',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Switches', 'spec_value' => 'Cherry MX Red'],
                    ['spec_name' => 'RGB', 'spec_value' => 'Per-Key RGB'],
                ]
            ],
            [
                'nombre' => 'Corsair Dark Core RGB Pro SE',
                'sku' => 'CORSAIR-DARKCORE',
                'descripcion' => 'Mouse gaming wireless con carga Qi y sensor 18,000 DPI.',
                'precio' => 499.00,
                'stock' => 40,
                'categoria' => 'Periféricos',
                'marca' => 'Corsair',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'DPI', 'spec_value' => '18,000'],
                    ['spec_name' => 'Batería', 'spec_value' => '50 horas'],
                ]
            ],

            // ===== SSD KINGSTON =====
            [
                'nombre' => 'Kingston KC3000 2TB NVMe PCIe 4.0',
                'sku' => 'KINGSTON-KC3000-2TB',
                'descripcion' => 'SSD NVMe de alto rendimiento con velocidades hasta 7,000 MB/s.',
                'precio' => 849.00,
                'stock' => 30,
                'categoria' => 'Almacenamiento',
                'marca' => 'Kingston',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '2TB'],
                    ['spec_name' => 'Lectura', 'spec_value' => '7,000 MB/s'],
                ]
            ],
            [
                'nombre' => 'Kingston NV2 1TB NVMe',
                'sku' => 'KINGSTON-NV2-1TB',
                'descripcion' => 'SSD NVMe económico para upgrades de PC.',
                'precio' => 349.00,
                'stock' => 70,
                'categoria' => 'Almacenamiento',
                'marca' => 'Kingston',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Capacidad', 'spec_value' => '1TB'],
                    ['spec_name' => 'Interfaz', 'spec_value' => 'PCIe 4.0'],
                ]
            ],

            // ===== MÁS PRODUCTOS ASUS =====
            [
                'nombre' => 'ASUS ROG Swift PG27AQDM 27" OLED 240Hz',
                'sku' => 'ASUS-PG27AQDM',
                'descripcion' => 'Monitor gaming OLED con 240Hz y tiempo de respuesta 0.03ms. G-Sync Ultimate.',
                'precio' => 4999.00,
                'stock' => 10,
                'categoria' => 'Monitores',
                'marca' => 'ASUS',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Tamaño', 'spec_value' => '27 pulgadas'],
                    ['spec_name' => 'Resolución', 'spec_value' => '2560x1440 (QHD)'],
                    ['spec_name' => 'Tasa de Refresco', 'spec_value' => '240Hz'],
                    ['spec_name' => 'Panel', 'spec_value' => 'OLED'],
                ]
            ],
            [
                'nombre' => 'ASUS TUF Gaming VG27AQ 27" IPS 165Hz',
                'sku' => 'ASUS-VG27AQ',
                'descripcion' => 'Monitor gaming IPS 1440p con 165Hz y G-Sync compatible.',
                'precio' => 1499.00,
                'stock' => 25,
                'categoria' => 'Monitores',
                'marca' => 'ASUS',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Tamaño', 'spec_value' => '27"'],
                    ['spec_name' => 'Resolución', 'spec_value' => '2560x1440'],
                    ['spec_name' => 'Tasa de Refresco', 'spec_value' => '165Hz'],
                ]
            ],

            // ===== PRODUCTOS ADICIONALES AMD =====
            [
                'nombre' => 'AMD Ryzen 5 7600',
                'sku' => 'AMD-7600',
                'descripcion' => 'Procesador gaming económico de 6 núcleos. Excelente para gaming 1080p/1440p.',
                'precio' => 999.00,
                'stock' => 40,
                'categoria' => 'Procesadores',
                'marca' => 'AMD',
                'destacado' => false,
                'specs' => [
                    ['spec_name' => 'Núcleos/Hilos', 'spec_value' => '6/12'],
                    ['spec_name' => 'Frecuencia', 'spec_value' => '5.1 GHz Boost'],
                ]
            ],

            // ===== PERIFÉRICOS ADICIONALES =====
            [
                'nombre' => 'Razer Viper V2 Pro',
                'sku' => 'RAZER-VIPER-V2',
                'descripcion' => 'Mouse ultraligero wireless para esports. 58g de peso, sensor 30K.',
                'precio' => 699.00,
                'stock' => 35,
                'categoria' => 'Periféricos',
                'marca' => 'Razer',
                'destacado' => true,
                'specs' => [
                    ['spec_name' => 'Peso', 'spec_value' => '58g'],
                    ['spec_name' => 'DPI', 'spec_value' => '30,000'],
                ]
            ],
        ];

        $this->command->info('🚀 Creando productos reales...');

        foreach ($productos as $prod) {
            $categoria = Category::where('name', $prod['categoria'])->first();
            $marca = Brand::where('name', $prod['marca'])->first();

            if (!$categoria || !$marca) {
                $this->command->warn("⚠️  Saltando {$prod['nombre']} - Categoría o Marca no encontrada");
                continue;
            }

            // Saltar si ya existe (por SKU o slug)
            $slug = Str::slug($prod['nombre']);
            if (Product::where('sku', $prod['sku'])->orWhere('slug', $slug)->exists()) {
                $this->command->warn("  ⏭️  {$prod['nombre']} - Ya existe");
                continue;
            }

            $producto = Product::create([
                'name' => $prod['nombre'],
                'sku' => $prod['sku'],
                'slug' => Str::slug($prod['nombre']),
                'description' => $prod['descripcion'],
                'price' => $prod['precio'],
                'stock' => $prod['stock'],
                'category_id' => $categoria->id,
                'brand_id' => $marca->id,
                'is_active' => true,
                'is_featured' => $prod['destacado'],
            ]);

            // Imagen placeholder
            $producto->images()->create([
                'image_path' => 'https://via.placeholder.com/600x600/0B0E14/0ea5e9?text=' . urlencode(substr($prod['nombre'], 0, 30)),
                'is_primary' => true,
                'order' => 0,
            ]);

            // Especificaciones
            foreach ($prod['specs'] as $spec) {
                $producto->specifications()->create($spec);
            }

            $this->command->info("  ✅ {$prod['nombre']}");
        }

        $this->command->info('');
        $this->command->info('🎉 ¡' . count($productos) . ' productos creados exitosamente!');
        $this->command->info('💡 Ahora puedes agregar imágenes reales desde el panel de administración.');
    }
}

