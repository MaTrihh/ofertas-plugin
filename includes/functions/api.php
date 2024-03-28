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
        return false;
    } else {
        return true;
    }
}

function crear_oferta() {

    if($_POST['descuento_precio'] == "on"){
        $descuento_normal = $_POST['descuento_precio_normal'];
        $descuento_final = $_POST['descuento_precio_rebajado'];
    }else{
        if($_POST['descuento_porcentaje'] == "on"){
            $descuento_normal = 0;
            $descuento_final = $_POST['descuento_porcentaje_numero'];
        }
    }

    if (isset($_FILES["inputFile"]) && $_FILES["inputFile"]["error"] == UPLOAD_ERR_OK) {
        if (isset($_FILES["inputFile"]) && $_FILES["inputFile"]["error"] == UPLOAD_ERR_OK) {
            $temp_name = $_FILES["inputFile"]["tmp_name"]; // Nombre temporal del archivo
            $file_name = $_FILES["inputFile"]["name"]; // Nombre original del archivo
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_name = generarNombreArchivoAleatorio() . '.' . $extension;

            // Ruta donde deseas guardar el archivo dentro de tu plugin
            $upload_dir = OFERTAS_PLUGIN_DIR . 'uploads/';
            $file_path = $upload_dir . $file_name; // Ruta completa del archivo
        
            // Mueve el archivo a la ubicación deseada
            move_uploaded_file($temp_name, $file_path);
        
            // Obtener la URL base de WordPress
            $base_url = home_url();
        
            // Construir la URL completa de la imagen
            $file_url = $base_url . '/wp-content/plugins/ofertas-plugin/uploads/' . $file_name;
        }
        
    }else{
        $file_path = get_user_meta($_POST['idAsociado'], 'logotipo', true);
    }

    $oferta = new Oferta('null', $_POST['idAsociado'], $_POST['titulo'], $_POST['descripcion'], $_POST['form_cantidad'], $descuento_normal, $descuento_final, $file_url, $_POST['form_fecha_inicio'], $_POST['form_fecha_fin']);
    $array = Oferta::ToArray($oferta);

    $resultado = addOferta($array);

    if($resultado){
        wp_send_json(array('error' => false, 'mensaje' => 'Todo ha salido bien'));
    }else{
        wp_send_json(array('error' => true, 'mensaje' => 'Error al crear la oferta'));
    };
}
add_action('wp_ajax_crear_oferta', 'crear_oferta');
add_action('wp_ajax_nopriv_crear_oferta', 'crear_oferta');

function generarNombreArchivoAleatorio($longitud = 8) {
    // Caracteres válidos para el nombre del archivo
    $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    $nombreArchivo = '';
    $longitudCaracteres = strlen($caracteres);
    for ($i = 0; $i < $longitud; $i++) {
        $indiceAleatorio = rand(0, $longitudCaracteres - 1);
        $nombreArchivo .= $caracteres[$indiceAleatorio];
    }

    return $nombreArchivo;
}