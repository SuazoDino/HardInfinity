<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['entrada', 'salida', 'estorno', 'ajuste']); // entrada=stock+, salida=venta, estorno=devolución, ajuste=corrección
            $table->integer('quantity'); // positivo o negativo
            $table->integer('stock_before'); // stock antes del movimiento
            $table->integer('stock_after'); // stock después del movimiento
            $table->string('reason')->nullable(); // razón del movimiento
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
