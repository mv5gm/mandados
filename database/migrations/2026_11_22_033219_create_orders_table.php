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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('conductor_id')->nullable()->constrained('conductores')->nullOnDelete();
            $table->foreignId('lote_id')->nullable()->constrained('lotes_pedidos')->nullOnDelete();
            $table->string('tipo_servicio', 20)->default('estándar')->index();
            $table->string('estado', 30)->default('recibido')->index();
            $table->uuid('client_uuid')->nullable()->unique();

            $table->string('tracking_mrw', 60);
            $table->string('remitente', 120)->nullable();
            $table->string('rango_peso', 20);
            $table->string('tipo_paquete', 20);

            $table->string('tipo_seguro', 20)->default('básico');
            $table->decimal('valor_declarado_usd', 12, 2)->nullable();
            $table->decimal('tarifa_seguro_usd', 12, 2)->default(0);
            $table->timestamp('aceptacion_terminos_el')->nullable();

            $table->string('sector_entrega', 120);
            $table->string('calle_entrega', 160)->nullable();
            $table->text('referencia_entrega')->nullable();
            $table->decimal('lat_entrega', 10, 7)->nullable();
            $table->decimal('lon_entrega', 10, 7)->nullable();

            $table->date('fecha_recogida_agendada')->nullable();
            $table->string('pin_entrega', 4)->nullable();
            $table->string('foto_recogida')->nullable();
            $table->string('foto_entrega')->nullable();
            $table->string('firma_entrega')->nullable();

            $table->decimal('tarifa_base_usd', 12, 2);
            $table->decimal('total_usd', 12, 2);
            $table->decimal('tasa_cambio', 18, 4)->nullable();
            $table->decimal('total_ves', 14, 2)->nullable();

            $table->string('metodo_pago', 20)->nullable();
            $table->string('estado_pago', 20)->default('pendiente')->index();
            $table->decimal('comision_plataforma_porc', 5, 2)->default(25);
            $table->decimal('comision_conductor_porc', 5, 2)->default(75);
            $table->decimal('ganancia_conductor_usd', 12, 2)->default(0);
            $table->decimal('ganancia_plataforma_usd', 12, 2)->default(0);

            $table->timestamp('aprobado_el')->nullable();
            $table->timestamp('asignado_el')->nullable();
            $table->timestamp('recogido_el')->nullable();
            $table->timestamp('en_trayecto_el')->nullable();
            $table->timestamp('entregado_el')->nullable();
            $table->timestamp('cancelado_el')->nullable();
            $table->text('motivo_cancelacion')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index(['cliente_id', 'estado']);
            $table->index(['conductor_id', 'estado']);
            $table->index(['estado', 'tipo_servicio', 'fecha_recogida_agendada']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
