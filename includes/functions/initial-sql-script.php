<?php

function ofertas_plugin_tablas() {
    ofertas_plugin_crear_tabla();
    ofertas_plugin_crear_tabla_canjeados();
}

function ofertas_plugin_crear_tabla() {
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'raffle_codes';

    $consulta_sql = "CREATE TABLE IF NOT EXISTS $tabla_nombre (
        id INT NOT NULL AUTO_INCREMENT,
        idAsociado BIGINT(20) NOT NULL UNIQUE,
        titulo VARCHAR(60) NOT NULL UNIQUE,
        descripcion VARCHAR(300) UNIQUE,
        cantidad INT,
        precio_normal DECIMAL(10, 2),
        precio_rebajado DECIMAL(10, 2),
        foto VARCHAR(255),
        fecha_inicio DATE,
        fecha_fin DATE,
        trash TINYINT,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $consulta_sql );
}

function ofertas_plugin_crear_tabla_canjeados() {
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'ofertas_canjeadas';

    $consulta_sql = "CREATE TABLE `mw2m_ofertas_canjeadas` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` bigint(20) NOT NULL,
        `oferta_id` int(5) NOT NULL,
        `canjeado` tinyint(4) NOT NULL,
        `fecha_canjeado` date DEFAULT NULL,
        PRIMARY KEY (`id`),
        CONSTRAINT unique_user_offer_combination UNIQUE (user_id, oferta_id)
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $consulta_sql );
}