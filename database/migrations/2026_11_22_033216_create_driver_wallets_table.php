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
        Schema::create('conductores_billeteras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conductor_id')->unique()->constrained('conductores')->cascadeOnDelete();
            $table->decimal('saldo_a_favor', 12, 2)->default(0);
            $table->decimal('saldo_prepayado', 12, 2)->default(0);
            $table->decimal('total_entregado', 12, 2)->default(0);
            $table->decimal('total_pagado', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores_billeteras');
    }
};
