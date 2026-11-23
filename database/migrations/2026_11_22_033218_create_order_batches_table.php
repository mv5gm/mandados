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
        Schema::create('lotes_pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('conductor_id')->nullable()->constrained('conductores')->nullOnDelete();
            $table->string('tipo_servicio', 20)->default('standard');
            $table->string('estado', 20)->default('open')->index();
            $table->date('fecha_agendada');
            $table->timestamp('hora_corte')->nullable();
            $table->timestamp('asignado_el')->nullable();
            $table->timestamp('completado_el')->nullable();
            $table->timestamps();

            $table->index(['tipo_servicio', 'estado', 'fecha_agendada']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lotes_pedidos');
    }
};
