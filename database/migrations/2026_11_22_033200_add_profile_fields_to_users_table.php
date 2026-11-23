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
            $table->string('cedula', 20)->nullable()->unique()->after('name');
            $table->string('phone', 30)->nullable()->after('cedula');
            $table->date('birth_date')->nullable()->after('phone');
            $table->timestamp('phone_verified_at')->nullable()->after('email_verified_at');
            $table->string('status', 20)->default('active')->index()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['cedula']);
            $table->dropColumn([
                'cedula',
                'phone',
                'birth_date',
                'phone_verified_at',
                'status',
            ]);
        });
    }
};
