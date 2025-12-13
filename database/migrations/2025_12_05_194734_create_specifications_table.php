<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('spec_name'); // ej: "Socket", "VRAM", "Frecuencia"
            $table->string('spec_value'); // ej: "LGA1700", "12GB", "3200MHz"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
