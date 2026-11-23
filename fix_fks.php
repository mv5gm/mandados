<?php

$map = [
    'database/migrations/2026_11_22_033206_create_client_addresses_table.php' => [
        ["\$table->foreignId('cliente_id')->constrained()", "\$table->foreignId('cliente_id')->constrained('users')"],
        ["Schema::dropIfExists('client_addresses')", "Schema::dropIfExists('direcciones_clientes')"],
    ],
    'database/migrations/2026_11_22_033208_create_drivers_table.php' => [
        ["\$table->foreignId('usuario_id')->unique()->constrained()", "\$table->foreignId('usuario_id')->unique()->constrained('users')"],
        ["\$table->foreignId('aprobado_por')->nullable()->constrained()", "\$table->foreignId('aprobado_por')->nullable()->constrained('users')"],
    ],
    'database/migrations/2026_11_22_033209_create_driver_documents_table.php' => [
        ["\$table->foreignId('conductor_id')->constrained()", "\$table->foreignId('conductor_id')->constrained('conductores')"],
    ],
    'database/migrations/2026_11_22_033216_create_driver_wallets_table.php' => [
        ["\$table->foreignId('conductor_id')->unique()->constrained()", "\$table->foreignId('conductor_id')->unique()->constrained('conductores')"],
    ],
    'database/migrations/2026_11_22_033218_create_order_batches_table.php' => [
        ["\$table->foreignId('conductor_id')->constrained()", "\$table->foreignId('conductor_id')->constrained('conductores')"],
    ],
    'database/migrations/2026_11_22_033221_create_order_status_histories_table.php' => [
        ["\$table->foreignId('pedido_id')->constrained()", "\$table->foreignId('pedido_id')->constrained('pedidos')"],
        ["\$table->foreignId('cambiado_por')->nullable()->constrained()", "\$table->foreignId('cambiado_por')->nullable()->constrained('users')"],
    ],
    'database/migrations/2026_11_22_033222_create_order_documents_table.php' => [
        ["\$table->foreignId('pedido_id')->constrained()", "\$table->foreignId('pedido_id')->constrained('pedidos')"],
        ["\$table->foreignId('subido_por')->nullable()->constrained()", "\$table->foreignId('subido_por')->nullable()->constrained('users')"],
    ],
    'database/migrations/2026_11_22_033224_create_payments_table.php' => [
        ["\$table->foreignId('pedido_id')->constrained()", "\$table->foreignId('pedido_id')->constrained('pedidos')"],
        ["\$table->foreignId('cliente_id')->nullable()->constrained()", "\$table->foreignId('cliente_id')->nullable()->constrained('users')"],
        ["\$table->foreignId('verificado_por')->nullable()->constrained()", "\$table->foreignId('verificado_por')->nullable()->constrained('users')"],
    ],
    'database/migrations/2026_11_22_033225_create_wallet_transactions_table.php' => [
        ["\$table->foreignId('conductor_id')->constrained()", "\$table->foreignId('conductor_id')->constrained('conductores')"],
        ["\$table->foreignId('pedido_id')->nullable()->constrained()", "\$table->foreignId('pedido_id')->nullable()->constrained('pedidos')"],
        ["\$table->foreignId('creado_por')->nullable()->constrained()", "\$table->foreignId('creado_por')->nullable()->constrained('users')"],
    ],
    'database/migrations/2026_11_22_033227_create_order_ratings_table.php' => [
        ["\$table->foreignId('pedido_id')->unique()->constrained()", "\$table->foreignId('pedido_id')->unique()->constrained('pedidos')"],
        ["\$table->foreignId('cliente_id')->nullable()->constrained()", "\$table->foreignId('cliente_id')->nullable()->constrained('users')"],
        ["\$table->foreignId('conductor_id')->nullable()->constrained()", "\$table->foreignId('conductor_id')->nullable()->constrained('conductores')"],
    ],
    'database/migrations/2026_11_22_033228_create_device_tokens_table.php' => [
        ["\$table->foreignId('usuario_id')->constrained()", "\$table->foreignId('usuario_id')->constrained('users')"],
    ],
    'database/migrations/2026_11_22_033204_create_exchange_rates_table.php' => [
        ["\$table->foreignId('creado_por')->nullable()->constrained()", "\$table->foreignId('creado_por')->nullable()->constrained('users')"],
    ],
];

foreach ($map as $file => $replacements) {
    $content = file_get_contents($file);
    foreach ($replacements as [$old, $new]) {
        if (str_contains($content, $old)) {
            $content = str_replace($old, $new, $content);
        }
    }
    file_put_contents($file, $content);
}

echo "FKs fixed\n";
