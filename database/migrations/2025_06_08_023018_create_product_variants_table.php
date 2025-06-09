<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Chave estrangeira para products
            $table->string('name'); // Ex: "R$ 50,00", "100 BRL", ou apenas o valor como "50"
            $table->decimal('price', 10, 2); // Preço da variante
            $table->string('sku')->nullable()->unique(); // SKU opcional e único
            $table->integer('stock')->default(0); // Estoque opcional
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};