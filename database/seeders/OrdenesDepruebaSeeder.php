<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;

class OrdenesDepruebaSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = User::where('email', 'cliente@hardinfinity.com')->first();
        
        if (!$cliente) {
            $this->command->error('❌ No existe el usuario cliente@hardinfinity.com');
            return;
        }

        $productos = Product::where('is_active', true)->get();
        
        if ($productos->count() < 3) {
            $this->command->error('❌ Necesitas al menos 3 productos activos');
            return;
        }

        $this->command->info('🛒 Creando órdenes de prueba...');

        // Orden 1: Entregada
        $orden1 = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $cliente->id,
            'status' => 'delivered',
            'subtotal' => 0,
            'tax' => 0,
            'shipping_cost' => 50.00,
            'discount' => 0,
            'total_amount' => 0,
            'payment_method' => 'Tarjeta de Crédito Visa',
            'payment_status' => 'paid',
            'shipping_address' => 'Av. Universitaria 1801, San Miguel, Lima 15088, Perú',
            'notes' => 'Cliente frecuente. Entrega express.',
        ]);

        $prod1 = $productos->where('name', 'LIKE', '%RTX 4090%')->first() ?? $productos->random();
        $prod2 = $productos->where('name', 'LIKE', '%Ryzen%')->first() ?? $productos->random();
        
        $orden1->items()->create([
            'product_id' => $prod1->id,
            'quantity' => 1,
            'unit_price' => $prod1->price,
            'subtotal' => $prod1->price,
        ]);
        
        $orden1->items()->create([
            'product_id' => $prod2->id,
            'quantity' => 1,
            'unit_price' => $prod2->price,
            'subtotal' => $prod2->price,
        ]);

        $subtotal = $orden1->items->sum('subtotal');
        $tax = $subtotal * 0.18;
        $total = $subtotal + $tax + 50;
        
        $orden1->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total_amount' => $total,
        ]);

        $this->command->info("  ✅ Orden #{$orden1->order_number} - Entregada (S/ {$total})");

        // Orden 2: Enviada
        $orden2 = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $cliente->id,
            'status' => 'shipped',
            'subtotal' => 0,
            'tax' => 0,
            'shipping_cost' => 50.00,
            'discount' => 0,
            'total_amount' => 0,
            'payment_method' => 'Yape',
            'payment_status' => 'paid',
            'shipping_address' => 'Jr. Lampa 545, Cercado de Lima, Lima 15001, Perú',
            'notes' => 'Coordinar horario de entrega.',
        ]);

        $prod3 = $productos->where('name', 'LIKE', '%Corsair%')->first() ?? $productos->random();
        $prod4 = $productos->where('name', 'LIKE', '%Kingston%')->first() ?? $productos->random();
        
        $orden2->items()->create([
            'product_id' => $prod3->id,
            'quantity' => 2,
            'unit_price' => $prod3->price,
            'subtotal' => $prod3->price * 2,
        ]);
        
        $orden2->items()->create([
            'product_id' => $prod4->id,
            'quantity' => 1,
            'unit_price' => $prod4->price,
            'subtotal' => $prod4->price,
        ]);

        $subtotal2 = $orden2->items->sum('subtotal');
        $tax2 = $subtotal2 * 0.18;
        $total2 = $subtotal2 + $tax2 + 50;
        
        $orden2->update([
            'subtotal' => $subtotal2,
            'tax' => $tax2,
            'total_amount' => $total2,
        ]);

        $this->command->info("  ✅ Orden #{$orden2->order_number} - Enviada (S/ {$total2})");

        // Orden 3: Pagada (reciente)
        $orden3 = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => $cliente->id,
            'status' => 'paid',
            'subtotal' => 0,
            'tax' => 0,
            'shipping_cost' => 0, // Envío gratis
            'discount' => 0,
            'total_amount' => 0,
            'payment_method' => 'Transferencia Bancaria BCP',
            'payment_status' => 'paid',
            'shipping_address' => 'Av. Arequipa 2985, Lince, Lima 15046, Perú',
            'notes' => 'Primera compra del cliente.',
        ]);

        $prod5 = $productos->where('name', 'LIKE', '%Intel%')->first() ?? $productos->random();
        $prod6 = $productos->where('name', 'LIKE', '%ASUS%')->first() ?? $productos->random();
        
        $orden3->items()->create([
            'product_id' => $prod5->id,
            'quantity' => 1,
            'unit_price' => $prod5->price,
            'subtotal' => $prod5->price,
        ]);
        
        $orden3->items()->create([
            'product_id' => $prod6->id,
            'quantity' => 1,
            'unit_price' => $prod6->price,
            'subtotal' => $prod6->price,
        ]);

        $subtotal3 = $orden3->items->sum('subtotal');
        $tax3 = $subtotal3 * 0.18;
        $total3 = $subtotal3 + $tax3;
        
        $orden3->update([
            'subtotal' => $subtotal3,
            'tax' => $tax3,
            'total_amount' => $total3,
        ]);

        $this->command->info("  ✅ Orden #{$orden3->order_number} - Pagada (S/ {$total3})");

        $this->command->info('');
        $this->command->info('🎉 ¡3 órdenes de prueba creadas exitosamente!');
        $this->command->info('💡 Ahora puedes generar PDFs desde el panel de admin.');
    }
}

