<?php
function ofertas_plugin_crear_tabla() {
    global $wpdb;
    $tabla_nombre = $wpdb->prefix . 'ofertas';

    $consulta_sql = "CREATE TABLE IF NOT EXISTS $tabla_nombre (
        id INT NOT NULL AUTO_INCREMENT,
        idAsociado BIGINT(20) NOT NULL,
        titulo VARCHAR(60) NOT NULL,
        descripcion VARCHAR(300),
        unidades INT,
        foto VARCHAR(255),
        fecha_inicio DATE,
        fecha_fin DATE,
        PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $consulta_sql );
}
