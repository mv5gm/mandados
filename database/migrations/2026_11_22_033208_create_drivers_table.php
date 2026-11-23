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
        Schema::create('conductores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->text('direccion');
            $table->string('nombre_contacto_emergencia', 120)->nullable();
            $table->string('telefono_contacto_emergencia', 30);
            $table->string('marca', 60);
            $table->string('modelo', 60);
            $table->unsignedSmallInteger('anio');
            $table->string('color', 40);
            $table->string('placa', 20)->unique();
            $table->string('estatus', 20)->default('pending')->index();
            $table->timestamp('aprobado_el')->nullable();
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->text('motivo_rechazo')->nullable();
            $table->boolean('disponible')->default(false)->index();
            $table->timestamp('ultima_asignacion_el')->nullable();
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->unsignedInteger('cantidad_calificaciones')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores');
    }
};
