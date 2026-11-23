<?php

$map = [
    // settings
    'database/migrations/2026_11_22_033202_create_settings_table.php' => [
        ["Schema::create('settings'", "Schema::create('ajustes'"],
        ["'key', 'unique'", "'clave', 'unique'"],
        ["\$table->string('key')->unique();", "\$table->string('clave')->unique();"],
        ["\$table->text('value')->nullable();", "\$table->text('valor')->nullable();"],
        ["'type' => 'decimal'", 'X'],
    ],
    'database/migrations/2026_11_22_033204_create_exchange_rates_table.php' => [
        ["Schema::create('exchange_rates'", "Schema::create('tasas_cambio'"],
        ["\$table->string('currency', 3)", "\$table->string('moneda', 3)"],
        ["\$table->decimal('rate', 18, 4)", "\$table->decimal('tasa', 18, 4)"],
        ["\$table->string('source', 20)", "\$table->string('origen', 20)"],
        ["\$table->date('effective_date')", "\$table->date('fecha_efectiva')"],
        ["\$table->boolean('is_active')", "\$table->boolean('activo')"],
        ["\$table->foreignId('created_by')", "\$table->foreignId('creado_por')"],
        ["['currency', 'is_active', 'effective_date']", "['moneda', 'activo', 'fecha_efectiva']"],
    ],
    'database/migrations/2026_11_22_033206_create_client_addresses_table.php' => [
        ["Schema::create('client_addresses'", "Schema::create('direcciones_clientes'"],
        ["\$table->foreignId('user_id')", "\$table->foreignId('cliente_id')"],
        ["[$table->index", "[\$table->index"],
        ["['user_id', 'is_default']", "['cliente_id', 'predeterminada']"],
        ["\$table->boolean('is_default')", "\$table->boolean('predeterminada')"],
        ["\$table->decimal('latitude', 10, 7)", "\$table->decimal('lat', 10, 7)"],
        ["\$table->decimal('longitude', 10, 7)", "\$table->decimal('lon', 10, 7)"],
        ["\$table->string('label', 60)", "\$table->string('tipo', 60)"],
    ],
    'database/migrations/2026_11_22_033208_create_drivers_table.php' => [
        ["Schema::create('drivers'", "Schema::create('conductores'"],
        ["\$table->foreignId('user_id')->unique()", "\$table->foreignId('usuario_id')->unique()"],
        ["\$table->text('address')", "\$table->text('direccion')"],
        ["\$table->string('emergency_contact_name', 120)", "\$table->string('nombre_contacto_emergencia', 120)"],
        ["\$table->string('emergency_contact_phone', 30)", "\$table->string('telefono_contacto_emergencia', 30)"],
        ["\$table->string('vehicle_brand', 60)", "\$table->string('marca', 60)"],
        ["\$table->string('vehicle_model', 60)", "\$table->string('modelo', 60)"],
        ["\$table->unsignedSmallInteger('vehicle_year')", "\$table->unsignedSmallInteger('anio')"],
        ["\$table->string('vehicle_color', 40)", "\$table->string('color', 40)"],
        ["\$table->string('vehicle_plate', 20)->unique()", "\$table->string('placa', 20)->unique()"],
        ["\$table->string('status', 20)", "\$table->string('estatus', 20)"],
        ["\$table->timestamp('approved_at')", "\$table->timestamp('aprobado_el')"],
        ["\$table->foreignId('approved_by')", "\$table->foreignId('aprobado_por')"],
        ["\$table->text('rejection_reason')", "\$table->text('motivo_rechazo')"],
        ["\$table->boolean('available')", "\$table->boolean('disponible')"],
        ["\$table->timestamp('last_assigned_at')", "\$table->timestamp('ultima_asignacion_el')"],
        ["\$table->decimal('rating_avg', 3, 2)", "\$table->decimal('calificacion_promedio', 3, 2)"],
        ["\$table->unsignedInteger('rating_count')", "\$table->unsignedInteger('cantidad_calificaciones')"],
    ],
    'database/migrations/2026_11_22_033209_create_driver_documents_table.php' => [
        ["Schema::create('driver_documents'", "Schema::create('conductores_documentos'"],
        ["\$table->foreignId('driver_id')", "\$table->foreignId('conductor_id')"],
        ["\$table->string('type', 30)", "\$table->string('tipo', 30)"],
        ["\$table->string('status', 20)", "\$table->string('estado', 20)"],
        ["\$table->timestamp('reviewed_at')", "\$table->timestamp('revision_el')"],
        ["\$table->foreignId('reviewed_by')", "\$table->foreignId('revision_por')"],
        ["\$table->text('notes')", "\$table->text('notas')"],
    ],
    'database/migrations/2026_11_22_033214_create_driver_payout_methods_table.php' => [
        ["Schema::create('driver_payout_methods'", "Schema::create('conductores_metodos_pago'"],
        ["\$table->foreignId('driver_id')", "\$table->foreignId('conductor_id')"],
        ["\$table->string('type', 20)", "\$table->string('tipo', 20)"],
        ["\$table->string('bank', 60)", "\$table->string('banco', 60)"],
        ["\$table->string('account_holder', 120)", "\$table->string('titular', 120)"],
        ["\$table->string('wallet_id', 120)", "\$table->string('id_billetera', 120)"],
        ["\$table->boolean('is_default')", "\$table->boolean('predeterminado')"],
        ["['driver_id', 'is_default']", "['conductor_id', 'predeterminado']"],
    ],
    'database/migrations/2026_11_22_033216_create_driver_wallets_table.php' => [
        ["Schema::create('driver_wallets'", "Schema::create('conductores_billeteras'"],
        ["\$table->foreignId('driver_id')->unique()", "\$table->foreignId('conductor_id')->unique()"],
        ["\$table->decimal('available_balance', 12, 2)", "\$table->decimal('saldo_a_favor', 12, 2)"],
        ["\$table->decimal('prepaid_balance', 12, 2)", "\$table->decimal('saldo_prepayado', 12, 2)"],
        ["\$table->decimal('total_earned', 12, 2)", "\$table->decimal('total_entregado', 12, 2)"],
        ["\$table->decimal('total_paid_out', 12, 2)", "\$table->decimal('total_pagado', 12, 2)"],
    ],
    'database/migrations/2026_11_22_033218_create_order_batches_table.php' => [
        ["Schema::create('order_batches'", "Schema::create('lotes_pedidos'"],
        ["\$table->foreignId('driver_id')", "\$table->foreignId('conductor_id')"],
        ["\$table->string('service_type', 20)", "\$table->string('tipo_servicio', 20)"],
        ["\$table->string('status', 20)", "\$table->string('estado', 20)"],
        ["\$table->date('scheduled_date')", "\$table->date('fecha_agendada')"],
        ["\$table->timestamp('cutoff_at')", "\$table->timestamp('hora_corte')"],
        ["\$table->timestamp('assigned_at')", "\$table->timestamp('asignado_el')"],
        ["\$table->timestamp('completed_at')", "\$table->timestamp('completado_el')"],
        ["['service_type', 'status', 'scheduled_date']", "['tipo_servicio', 'estado', 'fecha_agendada']"],
    ],
    'database/migrations/2026_11_22_033221_create_order_status_histories_table.php' => [
        ["Schema::create('order_status_histories'", "Schema::create('historial_pedidos'"],
        ["\$table->foreignId('order_id')", "\$table->foreignId('pedido_id')"],
        ["\$table->string('status', 30)", "\$table->string('estado', 30)"],
        ["\$table->foreignId('changed_by')", "\$table->foreignId('cambiado_por')"],
        ["['order_id', 'created_at']", "['pedido_id', 'created_at']"],
    ],
    'database/migrations/2026_11_22_033222_create_order_documents_table.php' => [
        ["Schema::create('order_documents'", "Schema::create('documentos_pedidos'"],
        ["\$table->foreignId('order_id')", "\$table->foreignId('pedido_id')"],
        ["\$table->string('type', 30)", "\$table->string('tipo', 30)"],
        ["\$table->string('status', 20)", "\$table->string('estado', 20)"],
        ["\$table->foreignId('uploaded_by')", "\$table->foreignId('subido_por')"],
    ],
    'database/migrations/2026_11_22_033224_create_payments_table.php' => [
        ["Schema::create('payments'", "Schema::create('pagos'"],
        ["\$table->foreignId('order_id')", "\$table->foreignId('pedido_id')"],
        ["\$table->foreignId('client_id')", "\$table->foreignId('cliente_id')"],
        ["\$table->string('method', 20)", "\$table->string('metodo', 20)"],
        ["\$table->string('currency', 3)", "\$table->string('moneda', 3)"],
        ["\$table->decimal('amount', 14, 2)", "\$table->decimal('monto', 14, 2)"],
        ["\$table->decimal('exchange_rate', 18, 4)", "\$table->decimal('tasa', 18, 4)"],
        ["\$table->decimal('amount_usd', 12, 2)", "\$table->decimal('monto_usd', 12, 2)"],
        ["\$table->string('reference', 60)", "\$table->string('referencia', 60)"],
        ["\$table->string('bank', 60)", "\$table->string('banco', 60)"],
        ["\$table->string('payer_phone', 30)", "\$table->string('telefono_pagante', 30)"],
        ["\$table->string('proof_path')", "\$table->string('prueba_path')"],
        ["\$table->string('status', 20)", "\$table->string('estado', 20)"],
        ["\$table->foreignId('verified_by')", "\$table->foreignId('verificado_por')"],
        ["\$table->timestamp('verified_at')", "\$table->timestamp('verificado_el')"],
        ["\$table->text('rejection_reason')", "\$table->text('motivo_rechazo')"],
        ["['order_id', 'status']", "['pedido_id', 'estado']"],
    ],
    'database/migrations/2026_11_22_033225_create_wallet_transactions_table.php' => [
        ["Schema::create('wallet_transactions'", "Schema::create('transacciones_billetera'"],
        ["\$table->foreignId('driver_id')", "\$table->foreignId('conductor_id')"],
        ["\$table->foreignId('order_id')", "\$table->foreignId('pedido_id')"],
        ["\$table->string('type', 30)", "\$table->string('tipo', 30)"],
        ["\$table->decimal('amount', 12, 2)", "\$table->decimal('monto', 12, 2)"],
        ["\$table->decimal('balance_after', 12, 2)", "\$table->decimal('saldo_final', 12, 2)"],
        ["\$table->string('description')", "\$table->string('descripcion')"],
        ["\$table->foreignId('created_by')", "\$table->foreignId('creado_por')"],
        ["['driver_id', 'created_at']", "['conductor_id', 'created_at']"],
    ],
    'database/migrations/2026_11_22_033227_create_order_ratings_table.php' => [
        ["Schema::create('order_ratings'", "Schema::create('calificaciones'"],
        ["\$table->foreignId('order_id')->unique()", "\$table->foreignId('pedido_id')->unique()"],
        ["\$table->foreignId('client_id')", "\$table->foreignId('cliente_id')"],
        ["\$table->foreignId('driver_id')", "\$table->foreignId('conductor_id')"],
        ["\$table->unsignedTinyInteger('rating')", "\$table->unsignedTinyInteger('puntuacion')"],
        ["['driver_id', 'rating']", "['conductor_id', 'puntuacion']"],
    ],
    'database/migrations/2026_11_22_033228_create_device_tokens_table.php' => [
        ["Schema::create('device_tokens'", "Schema::create('dispositivos_push'"],
        ["\$table->foreignId('user_id')", "\$table->foreignId('usuario_id')"],
        ["\$table->string('platform', 20)", "\$table->string('plataforma', 20)"],
    ],
    // orders migration
    'database/migrations/2026_11_22_033219_create_orders_table.php' => [
        ["Schema::create('orders'", "Schema::create('pedidos'"],
        ["\$table->foreignId('client_id')", "\$table->foreignId('cliente_id')"],
        ["\$table->foreignId('driver_id')", "\$table->foreignId('conductor_id')"],
        ["\$table->foreignId('batch_id')", "\$table->foreignId('lote_id')"],
        ["\$table->string('service_type', 20)", "\$table->string('tipo_servicio', 20)"],
        ["\$table->string('status', 30)", "\$table->string('estado', 30)"],
        ["\$table->string('mrw_tracking_number', 60)", "\$table->string('tracking_mrw', 60)"],
        ["\$table->string('sender_name', 120)", "\$table->string('remitente', 120)"],
        ["\$table->string('weight_range', 20)", "\$table->string('rango_peso', 20)"],
        ["\$table->string('package_size', 20)", "\$table->string('tipo_paquete', 20)"],
        ["\$table->string('insurance_type', 20)", "\$table->string('tipo_seguro', 20)"],
        ["\$table->decimal('declared_value_usd', 12, 2)", "\$table->decimal('valor_declarado_usd', 12, 2)"],
        ["\$table->decimal('insurance_fee_usd', 12, 2)", "\$table->decimal('tarifa_seguro_usd', 12, 2)"],
        ["\$table->timestamp('terms_accepted_at')", "\$table->timestamp('aceptacion_terminos_el')"],
        ["\$table->string('delivery_sector', 120)", "\$table->string('sector_entrega', 120)"],
        ["\$table->string('delivery_street', 160)", "\$table->string('calle_entrega', 160)"],
        ["\$table->text('delivery_reference')", "\$table->text('referencia_entrega')"],
        ["\$table->decimal('delivery_latitude', 10, 7)", "\$table->decimal('lat_entrega', 10, 7)"],
        ["\$table->decimal('delivery_longitude', 10, 7)", "\$table->decimal('lon_entrega', 10, 7)"],
        ["\$table->date('scheduled_pickup_date')", "\$table->date('fecha_recogida_agendada')"],
        ["\$table->string('delivery_pin', 4)", "\$table->string('pin_entrega', 4)"],
        ["\$table->string('pickup_confirmation_photo_path')", "\$table->string('foto_recogida')"],
        ["\$table->string('delivery_photo_path')", "\$table->string('foto_entrega')"],
        ["\$table->string('delivery_signature_path')", "\$table->string('firma_entrega')"],
        ["\$table->decimal('base_fare_usd', 12, 2)", "\$table->decimal('tarifa_base_usd', 12, 2)"],
        ["\$table->decimal('total_usd', 12, 2)", "\$table->decimal('total_usd', 12, 2)"],
        ["\$table->decimal('exchange_rate', 18, 4)", "\$table->decimal('tasa_cambio', 18, 4)"],
        ["\$table->string('payment_method', 20)", "\$table->string('metodo_pago', 20)"],
        ["\$table->string('payment_status', 20)", "\$table->string('estado_pago', 20)"],
        ["\$table->decimal('commission_platform_percent', 5, 2)", "\$table->decimal('comision_plataforma_porc', 5, 2)"],
        ["\$table->decimal('commission_driver_percent', 5, 2)", "\$table->decimal('comision_conductor_porc', 5, 2)"],
        ["\$table->decimal('driver_earnings_usd', 12, 2)", "\$table->decimal('ganancia_conductor_usd', 12, 2)"],
        ["\$table->decimal('platform_earnings_usd', 12, 2)", "\$table->decimal('ganancia_plataforma_usd', 12, 2)"],
        ["\$table->timestamp('approved_at')", "\$table->timestamp('aprobado_el')"],
        ["\$table->timestamp('assigned_at')", "\$table->timestamp('asignado_el')"],
        ["\$table->timestamp('picked_up_at')", "\$table->timestamp('recogido_el')"],
        ["\$table->timestamp('in_transit_at')", "\$table->timestamp('en_trayecto_el')"],
        ["\$table->timestamp('delivered_at')", "\$table->timestamp('entregado_el')"],
        ["\$table->timestamp('cancelled_at')", "\$table->timestamp('cancelado_el')"],
        ["\$table->text('cancellation_reason')", "\$table->text('motivo_cancelacion')"],
        ["['client_id', 'status']", "['cliente_id', 'estado']"],
        ["['driver_id', 'status']", "['conductor_id', 'estado']"],
    ],
];

foreach ($map as $file => $replacements) {
    $content = file_get_contents($file);
    foreach ($replacements as [$old, $new]) {
        if (!is_string($new) || str_contains($old, 'X') ? str_contains($old, 'X') : true) {
            // skip placeholder entries
            if ($old === "'type' => 'decimal'") {
                continue;
            }
        }
        if (str_contains($old, 'X')) {
            continue;
        }
        $content = str_replace($old, $new, $content);
    }
    // replace FK definitions target names
    $content = str_replace("->constrained('drivers')", "->constrained('conductores')", $content);
    $content = str_replace("->constrained('order_batches')", "->constrained('lotes_pedidos')", $content);
    $content = str_replace("->constrained('users')", "->constrained('users')", $content);
    file_put_contents($file, $content);
    echo "Processed: $file\n";
}

echo "Done.\n";
