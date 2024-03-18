<?php
function getOfertas() {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT * FROM $tabla_ofertas";
    $resultados = $wpdb->get_results($consulta_sql);

    $ofertas = array();

    // Recorrer los resultados y crear objetos Oferta
    foreach ($resultados as $fila) {
        $oferta = new Oferta(
            $fila->id,
            $fila->idAsociado,
            $fila->titulo,
            $fila->descripcion,
            $fila->unidades,
            $fila->foto,
            $fila->fecha_inicio,
            $fila->fecha_fin
        );
        // Agregar la oferta al array
        $ofertas[] = $oferta;
    }

    return $ofertas;
}