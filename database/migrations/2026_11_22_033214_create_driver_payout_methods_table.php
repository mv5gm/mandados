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
        Schema::create('conductores_metodos_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conductor_id')->constrained('conductores')->cascadeOnDelete();
            $table->string('tipo', 20)->index();
            $table->string('banco', 60)->nullable();
            $table->string('titular', 120)->nullable();
            $table->string('cedula', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('id_billetera', 120)->nullable();
            $table->boolean('predeterminado')->default(false);
            $table->timestamps();

            $table->index(['conductor_id', 'predeterminado']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductores_metodos_pago');
    }
};
