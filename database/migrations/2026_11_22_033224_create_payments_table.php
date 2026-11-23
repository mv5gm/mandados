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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->cascadeOnDelete();
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('metodo', 20)->index();
            $table->string('moneda', 3)->default('USD');
            $table->decimal('monto', 14, 2);
            $table->decimal('tasa', 18, 4)->nullable();
            $table->decimal('monto_usd', 12, 2);
            $table->string('referencia', 60)->nullable();

            $table->string('banco', 60)->nullable();
            $table->string('telefono_pagante', 30)->nullable();
            $table->string('prueba_path')->nullable();

            $table->string('estado', 20)->default('pendiente')->index();
            $table->foreignId('verificado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verificado_el')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->timestamps();

            $table->index(['pedido_id', 'estado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
