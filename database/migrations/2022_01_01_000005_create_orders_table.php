<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique()->nullable();
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending')->index();
            $table->string('payment_method')->nullable()->index();
            $table->string('payment_status')->default('pending')->index();
            $table->string('transaction_id')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};