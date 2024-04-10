<?php
function getOfertas($offset = null, $limit = null, $trash = 0) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = ($offset != null && $limit != null) ? "SELECT * FROM $tabla_ofertas WHERE trash = $trash LIMIT $offset, $limit" : "SELECT * FROM $tabla_ofertas WHERE trash = $trash";
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
            $fila->fecha_fin,
            $fila->trash
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
        '%s',  // fecha_fin (cadena de texto en formato de fecha YYYY-MM-DD)
        '%d' // trash (entero)
    );

    $wpdb->insert($tabla_ofertas, $oferta, $formatos);

    if ($wpdb->last_error) {
        return false;
    } else {
        return true;
    }
}

function deleteOferta($id) {

    global $wpdb;
    $tabla = $wpdb->prefix . 'ofertas';

    $oferta = getOfertaById($id);
    $oferta->setTrash(1);
    
    // Verificar si el objeto oferta tiene un ID válido
    if (isset($oferta->id) && $oferta->id > 0) {
        // Obtener el nombre de la tabla de ofertas
        $tabla_ofertas = $wpdb->prefix . 'ofertas';
        
        // Convertir el objeto oferta a un array asociativo
        $datos_actualizar = Oferta::ToArray($oferta);
        
        // Construir la condición WHERE
        $condicion = array('id' => $oferta->id);
        
        // Realizar la actualización en la base de datos
        $resultado = $wpdb->update($tabla_ofertas, $datos_actualizar, $condicion);
        
        // Verificar si la actualización fue exitosa
        if ($resultado !== false) {
            return true; // La actualización fue exitosa
        } else {
            return false; // La actualización falló
        }
    } else {
        return false; // El objeto oferta no tiene un ID válido
    }
    
}

function updateOferta($oferta) {
    global $wpdb;
    
    // Verificar si el objeto oferta tiene un ID válido
    if (isset($oferta->id) && $oferta->id > 0) {
        // Obtener el nombre de la tabla de ofertas
        $tabla_ofertas = $wpdb->prefix . 'ofertas';
        
        // Convertir el objeto oferta a un array asociativo
        $datos_actualizar = Oferta::ToArray($oferta);
        
        // Construir la condición WHERE
        $condicion = array('id' => $oferta->id);
        
        // Realizar la actualización en la base de datos
        $resultado = $wpdb->update($tabla_ofertas, $datos_actualizar, $condicion);
        
        // Verificar si la actualización fue exitosa
        if ($resultado !== false) {
            return true; // La actualización fue exitosa
        } else {
            return false; // La actualización falló
        }
    } else {
        return false; // El objeto oferta no tiene un ID válido
    }
}

function get_oferta_by_id_callback() {

    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    $id = $_POST['id'];

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT * FROM $tabla_ofertas WHERE id = $id";
    $resultados = $wpdb->get_results($consulta_sql);

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
    }

    wp_send_json(array('oferta' => $oferta));
}
add_action('wp_ajax_get_oferta_by_id', 'get_oferta_by_id_callback');
add_action('wp_ajax_nopriv_get_oferta_by_id', 'get_oferta_by_id_callback');

function getOfertaById($id) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT * FROM $tabla_ofertas WHERE id = $id";
    $resultados = $wpdb->get_results($consulta_sql);

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
            $fila->fecha_fin,
            $fila->trash
        );
    }

    return $oferta;
}

function getOfertaByIdAsociado($id) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT * FROM $tabla_ofertas WHERE idAsociado = $id";
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
            $fila->fecha_fin,
            $fila->trash
        );

        $ofertas[] = $oferta;
    }

    return $ofertas;
}

function editar_oferta() {
    $oferta = getOfertaById($_POST['id']);

    $oferta->setTitulo($_POST['titulo']);
    $oferta->setDescripcion($_POST['descripcion']);
    $oferta->setCantidad($_POST['cantidad']);
    $oferta->setFechaInicio($_POST['fecha_inicio']);
    $oferta->setFechaFin($_POST['fecha_fin']);

    $resultado = updateOferta($oferta);

    if($resultado){
        wp_send_json(array('error' => false, 'mensaje' => 'Editado con exito'));
    }else{
        wp_send_json(array('error' => true, 'mensaje' => 'Error al editar oferta'));
    }

}
add_action('wp_ajax_editar_oferta', 'editar_oferta');
add_action('wp_ajax_nopriv_editar_oferta', 'editar_oferta');

function borrar_oferta() {
    $id = $_POST['id'];

    $resultado = deleteOferta($id);

    if($resultado){
        wp_send_json(array('error' => false, 'mensaje' => 'Borrado con exito'));
    }else{
        wp_send_json(array('error' => true, 'mensaje' => 'Error al borrar oferta'));
    }
}
add_action('wp_ajax_borrar_oferta', 'borrar_oferta');
add_action('wp_ajax_nopriv_borrar_oferta', 'borrar_oferta');

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

    $oferta = new Oferta('null', $_POST['idAsociado'], $_POST['titulo'], $_POST['descripcion'], $_POST['form_cantidad'], $descuento_normal, $descuento_final, $file_url, $_POST['form_fecha_inicio'], $_POST['form_fecha_fin'], 0);
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

function getOfertasSinCanjear($ids) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas';

    if(!empty($ids)){
        $ofertas = array();
        $idsExcluidos = implode(',', $ids);

        // Consulta para seleccionar todas las filas de la tabla de ofertas
        $consulta_sql = "SELECT * FROM mw2m_ofertas WHERE id NOT IN ($idsExcluidos) AND trash = 0"; 
        $resultados = $wpdb->get_results($consulta_sql);

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
                $fila->fecha_fin,
                $fila->trash
            );

            $ofertas[] = $oferta;
        }

        return $ofertas;
    }else{
        $ofertas = array();
        $idsExcluidos = implode(',', $ids);

        // Consulta para seleccionar todas las filas de la tabla de ofertas
        $consulta_sql = "SELECT * FROM mw2m_ofertas WHERE trash = 0"; 
        $resultados = $wpdb->get_results($consulta_sql);

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
                $fila->fecha_fin,
                $fila->trash
            );

            $ofertas[] = $oferta;
        }

        return $ofertas;
    }
}

function getOfertasCanjeadas($offset = null, $limit = null) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = ($offset != null && $limit != null) ? "SELECT * FROM $tabla_ofertas LIMIT $offset, $limit" : "SELECT * FROM $tabla_ofertas";
    $resultados = $wpdb->get_results($consulta_sql);

    $ofertas_canjeadas = array();

    // Recorrer los resultados y crear objetos Oferta
    foreach ($resultados as $fila) {
        $oferta = new OfertaCanjeada(
            $fila->id,
            $fila->user_id,
            $fila->oferta_id,
            $fila->canjeado,
            $fila->fecha_canjeado
        );
        // Agregar la oferta al array
        $ofertas_canjeadas[] = $oferta;
    }

    return $ofertas_canjeadas;
}

function getOfertaCanjeadaById($id) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT * FROM $tabla_ofertas WHERE id = $id";
    $resultados = $wpdb->get_results($consulta_sql);

    // Recorrer los resultados y crear objetos Oferta
    foreach ($resultados as $fila) {
        $oferta = new OfertaCanjeada(
            $fila->id,
            $fila->user_id,
            $fila->oferta_id,
            $fila->canjeado,
            $fila->fecha_canjeado
        );
    }

    return $oferta;
}

function getOfertasGuardadasByUserId($user_id, $onlyId = false, $onlyOfertas = false) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT oferta_id FROM $tabla_ofertas WHERE user_id = $user_id AND canjeado = 0";
    $resultados = $wpdb->get_results($consulta_sql);
    $idsOfertas = array();
    $ofertasCanjeadas = array();

    // Recorrer los resultados y crear objetos Oferta
    foreach ($resultados as $fila) {
        $idsOfertas[] = $fila->oferta_id;
    }

    if($onlyId){
        return $idsOfertas;
    }
    
    if(!empty($idsOfertas)){
        if($onlyOfertas){
            $tabla_ofertas2 = $wpdb->prefix . 'ofertas';

            $ids = implode(',', $idsOfertas);
            // Consulta para seleccionar todas las filas de la tabla de ofertas
            $consulta_sql2 = "SELECT * FROM $tabla_ofertas2 WHERE id IN ($ids)";
            $resultados2 = $wpdb->get_results($consulta_sql2);

            // Recorrer los resultados y crear objetos Oferta
            foreach ($resultados2 as $fila2) {
                $ofertaCanjeada = new Oferta(
                    $fila2->id,
                    $fila2->idAsociado,
                    $fila2->titulo,
                    $fila2->descripcion,
                    $fila2->cantidad,
                    $fila2->precio_normal,
                    $fila2->precio_rebajado,
                    $fila2->foto,
                    $fila2->fecha_inicio,
                    $fila2->fecha_fin,
                    $fila2->trash
                );

                $ofertasCanjeadas[] = $ofertaCanjeada;
            }

            return $ofertasCanjeadas;
        }else{
            $ids = implode(',', $idsOfertas);
            // Consulta para seleccionar todas las filas de la tabla de ofertas
            $consulta_sql2 = "SELECT * FROM $tabla_ofertas WHERE id IN ($ids)";
            $resultados2 = $wpdb->get_results($consulta_sql2);

            // Recorrer los resultados y crear objetos Oferta
            foreach ($resultados2 as $fila2) {
                $ofertaCanjeada = new OfertaCanjeada(
                    $fila2->id,
                    $fila2->user_id,
                    $fila2->oferta_id,
                    $fila2->canjeado,
                    $fila2->fecha_canjeado
                );

                $ofertasCanjeadas[] = $ofertaCanjeada;
            }

            return $ofertasCanjeadas;
        }
    }

    return array();

}

function addOfertaCanjeada($oferta) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';

    $formatos = array(
        '%d', // id (entero)
        '%d', // user_id (entero)
        '%d', // oferta_id (entero)
        '%d', // canjeado (entero)
        '%s', // fecha_canjeado (cadena de texto en formato de fecha YYYY-MM-DD)
    );

    $wpdb->insert($tabla_ofertas, $oferta, $formatos);

    if ($wpdb->last_error) {
        return false;
    } else {
        return true;
    }
}

function deleteOfertaCanjeadas($id) {

    global $wpdb;
    $tabla = $wpdb->prefix . 'ofertas_canjeadas';
    
    // Verificar si la tabla existe en la base de datos
    if ($wpdb->get_var("SHOW TABLES LIKE '$tabla'") == $tabla) {
        // Realizar la consulta de eliminación
        $result = $wpdb->delete($tabla, array('id' => $id));
        
        // Verificar si la eliminación fue exitosa
        if ($result !== false) {
            return true; // La eliminación fue exitosa
        } else {
            return false; // La eliminación falló
        }
    } else {
        return false; // La tabla no existe en la base de datos
    }
    
}

function updateOfertaCanjeadas($oferta) {
    global $wpdb;
    
    // Verificar si el objeto oferta tiene un ID válido
    if (isset($oferta->id) && $oferta->id > 0) {
        // Obtener el nombre de la tabla de ofertas
        $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';
        
        // Convertir el objeto oferta a un array asociativo
        $datos_actualizar = OfertaCanjeada::ToArray($oferta);
        
        // Construir la condición WHERE
        $condicion = array('id' => $oferta->id);
        
        // Realizar la actualización en la base de datos
        $resultado = $wpdb->update($tabla_ofertas, $datos_actualizar, $condicion);
        
        // Verificar si la actualización fue exitosa
        if ($resultado !== false) {
            return true; // La actualización fue exitosa
        } else {
            return false; // La actualización falló
        }
    } else {
        return false; // El objeto oferta no tiene un ID válido
    }
}

function asignar_oferta_usuario() {

    $oferta_info = getOfertaById($_POST['id']);

    if($oferta_info->cantidad != -1 && $oferta_info->cantidad != 0){
        disminuirCantidad($oferta_info);
    }

    $oferta = new OfertaCanjeada('null', $_POST['user_id'], $_POST['id'], 0, 'null');

    $resultado = addOfertaCanjeada($oferta::ToArray($oferta));

    if($resultado){
        wp_send_json(array('error' => false, 'mensaje' => 'Todo ha salido bien'));
    }else{
        wp_send_json(array('error' => true, 'mensaje' => 'Error al crear la oferta'));
    };

}
add_action('wp_ajax_asignar_oferta_usuario', 'asignar_oferta_usuario');
add_action('wp_ajax_nopriv_asignar_oferta_usuario', 'asignar_oferta_usuario');

function get_user_by_dni()
{

    $nicename = $_POST['dni'];

    $user = get_user_by('login', $nicename);

    if ($user) {
        $user_id = $user->ID;
        wp_send_json(array('success' => true, 'id' => $user_id));
    } else {
        wp_send_json(array('success' => false));
    }

}
add_action('wp_ajax_get_user_by_dni', 'get_user_by_dni');

function buscar_ofertas()
{

    $user_id = $_POST['user_id'];
    $ofertas = getOfertasSinCanjearUserId($user_id);
    $user_name = get_userdata($user_id)->first_name . ' ' . get_userdata($user_id)->last_name;

    if (!empty($ofertas)) {
        wp_send_json(array('success' => true, 'ofertas' => $ofertas, 'username' => $user_name));
    } else {
        wp_send_json(array('success' => false));
    }

}
add_action('wp_ajax_buscar_ofertas', 'buscar_ofertas');

function getOfertasSinCanjearUserId($user_id) {
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT oferta_id FROM $tabla_ofertas WHERE user_id = $user_id";
    $resultados = $wpdb->get_results($consulta_sql);
    $idsOfertas = array();
    $ofertasSinCanjear = array();

    // Recorrer los resultados y crear objetos Oferta
    foreach ($resultados as $fila) {
        $idsOfertas[] = $fila->oferta_id;
    }
    
    if(!empty($idsOfertas)){
        $tabla_ofertas2 = $wpdb->prefix . 'ofertas';

        $ids = implode(',', $idsOfertas);
        // Consulta para seleccionar todas las filas de la tabla de ofertas
        $consulta_sql2 = "SELECT * FROM $tabla_ofertas2 WHERE id NOT IN ($ids) AND trash = 0";
        $resultados2 = $wpdb->get_results($consulta_sql2);

        // Recorrer los resultados y crear objetos Oferta
        foreach ($resultados2 as $fila2) {
            $ofertaCanjeada = new Oferta(
                $fila2->id,
                $fila2->idAsociado,
                $fila2->titulo,
                $fila2->descripcion,
                $fila2->cantidad,
                $fila2->precio_normal,
                $fila2->precio_rebajado,
                $fila2->foto,
                $fila2->fecha_inicio,
                $fila2->fecha_fin,
                $fila2->trash
            );

            $ofertasSinCanjear[] = $ofertaCanjeada;
        }

        return $ofertasSinCanjear;
    }else{
        $tabla_ofertas2 = $wpdb->prefix . 'ofertas';

        $consulta_sql2 = "SELECT * FROM $tabla_ofertas2 WHERE trash = 0";
        $resultados2 = $wpdb->get_results($consulta_sql2);

        // Recorrer los resultados y crear objetos Oferta
        foreach ($resultados2 as $fila2) {
            $ofertaCanjeada = new Oferta(
                $fila2->id,
                $fila2->idAsociado,
                $fila2->titulo,
                $fila2->descripcion,
                $fila2->cantidad,
                $fila2->precio_normal,
                $fila2->precio_rebajado,
                $fila2->foto,
                $fila2->fecha_inicio,
                $fila2->fecha_fin,
                $fila2->trash
            );

            $ofertasSinCanjear[] = $ofertaCanjeada;
        }

        return $ofertasSinCanjear;
    }
}

function buscarOfertaCanjeada($oferta_id, $user_id){
    global $wpdb;
    $tabla_ofertas = $wpdb->prefix . 'ofertas_canjeadas';

    // Consulta para seleccionar todas las filas de la tabla de ofertas
    $consulta_sql = "SELECT * FROM $tabla_ofertas WHERE oferta_id = $oferta_id AND user_id = $user_id";
    $resultados = $wpdb->get_results($consulta_sql);

    // Verificar si se encontraron resultados
    if ($resultados) {
        // Declarar la variable $oferta fuera del bucle
        $oferta = null;

        // Recorrer los resultados y crear objetos Oferta
        foreach ($resultados as $fila) {
            $oferta = new OfertaCanjeada(
                $fila->id,
                $fila->user_id,
                $fila->oferta_id,
                $fila->canjeado,
                $fila->fecha_canjeado
            );
        }

        return $oferta;
    } else {
        // Si no se encontraron resultados, devolver null o manejar el caso según tu lógica de aplicación
        return null;
    }
}

function user_oferta() {

    $ids = $_POST['valoresCheckbox'];
    $user_id = $_POST['user_id'];

    foreach($ids as $oferta_id){
        $oferta = buscarOfertaCanjeada($oferta_id, $user_id);

        if ($oferta instanceof OfertaCanjeada) {
            $oferta->setCanjeado(1);
            updateOfertaCanjeadas($oferta);
        }else{
            wp_send_json(array('success' => false));
        }

        
    }

    wp_send_json(array('success' => true));
}
add_action('wp_ajax_user_oferta', 'user_oferta');

function disminuirCantidad($oferta){
    $cantidad = $oferta->cantidad;

    $cantidad--;

    if($cantidad == 0 || 0 > $cantidad){

        $oferta->setTrash(1);
        $oferta->setCantidad($cantidad);

    }else{
        $oferta->setCantidad($cantidad);
    }

    updateOferta($oferta);
}

