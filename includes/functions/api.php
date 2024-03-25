<?php
function getOfertas($offset = null, $limit = null) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = ($offset != null && $limit != null) ? "SELECT * FROM $tabla_ofertas LIMIT $offset, $limit" : "SELECT * FROM $tabla_ofertas";
    $resultados = $wpdb->get_results($consulta_sql);

    $ofertas = array();

    // Recorrer los resultados y crear objetos Oferta
    foreach ($resultados as $fila) {
        $oferta = new Oferta(
            $fila->id,
            $fila->idAsociado,
            $fila->titulo,
            $fila->descripcion,
            $fila->cantidad,
            $fila->precio_normal,
            $fila->precio_rebajado,
            $fila->foto,
            $fila->fecha_inicio,
            $fila->fecha_fin
        );
        // Agregar la oferta al array
        $ofertas[] = $oferta;
    }

    return $ofertas;
}

function addOferta($oferta) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    $formatos = array(
        '%d', // id (entero)
        '%d', // idAsociado (entero)
        '%s', // titulo (cadena de texto)
        '%s', // descripcion (cadena de texto)
        '%d', // cantidad (entero)
        '%f', // precio_normal (decimal)
        '%f', // precio_rebajado (decimal)
        '%s', // foto (cadena de texto)
        '%s', // fecha_inicio (cadena de texto en formato de fecha YYYY-MM-DD)
        '%s'  // fecha_fin (cadena de texto en formato de fecha YYYY-MM-DD)
    );

    $wpdb->insert($tabla_ofertas, $oferta, $formatos);

    if ($wpdb->last_error) {
        echo false;
    } else {
        echo true;
    }
}