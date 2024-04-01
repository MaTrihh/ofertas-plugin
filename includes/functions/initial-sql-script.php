<?php

function ofertas_plugin_tablas() {
    ofertas_plugin_crear_tabla();
    ofertas_plugin_crear_tabla_canjeados();
}

function ofertas_plugin_crear_tabla() {
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'ofertas';

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

    $consulta_sql = "CREATE TABLE IF NOT EXISTS $tabla_nombre (
        id INT NOT NULL AUTO_INCREMENT,
        user_id BIGINT(20) NOT NULL UNIQUE,
        oferta_id INT(5) NOT NULL UNIQUE,
        canjeado TINYINT NOT NULL,
        fecha_canjeado DATE,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $consulta_sql );
}