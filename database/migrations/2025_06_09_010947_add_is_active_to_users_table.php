<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adiciona a coluna 'is_active' depois da coluna 'is_admin' (ou onde preferir na sua tabela).
            // Default(true) significa que novos usuários serão ativos por padrão.
            // Se a coluna 'is_admin' não existir ou você quiser em outro lugar, ajuste o ->after().
            // Se não houver 'is_admin' ou não quiser especificar a posição, pode remover o ->after().
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_active')->default(true)->after('is_admin');
            } else {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};