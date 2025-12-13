<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['view', 'cart_add', 'wishlist_add', 'purchase'])->default('view');
            $table->timestamps();
            
            // Índice para consultas rápidas de recomendaciones
            $table->index(['user_id', 'product_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_interactions');
    }
};
