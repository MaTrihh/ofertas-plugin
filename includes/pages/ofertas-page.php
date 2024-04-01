<?php

function ofertas_plugin_tabla_page()
{
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        #myModal {
            display: none;
        }

        h2 {
            margin-top: 5px;
        }
    </style>
    <script>
        jQuery(document).ready(function () {

            jQuery("#editar-cupon-btn").click(function () {
                var id = jQuery(this).data('id');

                jQuery.ajax({
                    url: ajaxurl, // El punto de entrada AJAX proporcionado por WordPress
                    type: 'POST',
                    data: {
                        action: 'get_oferta_by_id',
                        id: id
                    },
                    success: function (response) {
                        if (response.oferta) {
                            let oferta = response.oferta;
                            
                            jQuery('#titulo').val(oferta['titulo']);
                            jQuery('#descripcion').val(oferta['descripcion']);
                            jQuery('#cantidad').val(oferta['cantidad']);
                            jQuery('#fecha_inicio').val(oferta['fecha_inicio']);
                            jQuery('#fecha_fin').val(oferta['fecha_fin']);
                            jQuery('#myModal').modal('show');

                        }
                    },
                    error: function (xhr, status, error) {
                        // Manejar errores
                        console.error(error);
                    }
                });
            });

            jQuery("#editar-form").submit(function (event) {

                event.preventDefault();

                var id = jQuery('#editar-cupon-btn').data('id');
                var titulo = jQuery('#titulo').val();
                var descripcion = jQuery('#descripcion').val();
                var cantidad = jQuery('#cantidad').val();
                var fecha_inicio = jQuery('#fecha_inicio').val();
                var fecha_fin = jQuery('#fecha_fin').val();

                jQuery.ajax({
                    url: ajaxurl, // El punto de entrada AJAX proporcionado por WordPress
                    type: 'POST',
                    data: {
                        action: 'editar_oferta',
                        id: id,
                        titulo: titulo,
                        descripcion: descripcion,
                        cantidad: cantidad,
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    },
                    success: function (response) {
                        if (response.error) {
                            alert(response.mensaje);
                            location.reload();
                        } else {
                            alert(response.mensaje);
                        }
                    },
                    error: function (xhr, status, error) {
                        // Manejar errores
                        console.error(error);
                    }
                });
            });

            jQuery("#confirmarBorrado").click(function () {
                    var id = jQuery(".borrar-cupon-btn").data('id');

                    jQuery.ajax({
                        url: ajaxurl, // El punto de entrada AJAX proporcionado por WordPress
                        type: 'POST',
                        data: {
                            action: 'borrar_oferta',
                            id: id
                        },
                        success: function (response) {
                            if (response.error) {
                                alert(response.mensaje);
                            } else {
                                jQuery('#confirmarBorradoModal').hide();
                                location.reload();
                            }
                        },
                        error: function (xhr, status, error) {
                            // Manejar errores
                            console.error(error);
                        }
                    });
                });


        })
    </script>
    <h2>Cupones creados</h2>
    <div class="containerDiv">
        <table>
            <thead>
                <tr>
                    <th>Nombre Comercio</th>
                    <th>Titulo</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Normal</th>
                    <th>Precio Rebajado</th>
                    <th>Foto</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $resultados_por_pagina = 10;

                // Página actual
                $pagina_actual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                // Calcular el offset
                $offset = ($pagina_actual - 1) * $resultados_por_pagina;

                $cupones = getOfertas($offset, $resultados_por_pagina);

                $total_resultados = count(getOfertas());

                $total_paginas = ceil($total_resultados / $resultados_por_pagina);

                // Obtener la URL base de WordPress
                $base_url = home_url();

                // Obtener la parte de la URL después del nombre de dominio
                $path = $_SERVER['REQUEST_URI'];

                // Combinar la URL base con el resto de la URL
                $url = $base_url . $path;

                foreach ($cupones as $cupon) {
                    ?>
                    <tr>
                        <td>
                            <?php echo get_userdata($cupon->getIdAsociado())->first_name; ?>
                        </td>
                        <td>
                            <?php echo $cupon->getTitulo(); ?>
                        </td>
                        <td>
                            <?php echo $cupon->getDescripcion(); ?>
                        </td>

                        <td>
                            <?php echo ($cupon->getCantidad() != -1) ? $cupon->getCantidad() : "Ilimitado"; ?>
                        </td>

                        <td>
                            <?php echo $cupon->getPrecioNormal(); ?>
                        </td>

                        <td>
                            <?php echo $cupon->getPrecioRebajado(); ?>
                        </td>

                        <td>
                            <?php echo ($cupon->getFoto() != null) ? "<a href=" . $cupon->getFoto() . ">Ver Foto</a>" : ""; ?>
                        </td>

                        <td>
                            <?php echo $cupon->getFechaInicio(); ?>
                        </td>

                        <td>
                            <?php echo $cupon->getFechaFin(); ?>
                        </td>

                        <td>
                            <button type="button" class="editar-cupon-btn" id="editar-cupon-btn"
                                data-id="<?php echo $cupon->getId(); ?>">Editar</button>
                                <button type="button" class="borrar-cupon-btn" id="borrar-cupon-btn"
                                data-id="<?php echo $cupon->getId(); ?>" data-toggle="modal" data-target="#confirmarBorradoModal">Borrar</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Paginación -->
    <div class="pagination">
        <?php if ($total_paginas > 1): ?>
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href=<?php echo $url . '&pagina=' . $i; ?>             <?php echo ($pagina_actual == $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar Oferta</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form id="editar-form">

                        <div class="form-datos">
                            <label for="titulo">Titulo:</label>
                            <input type="text" id="titulo" name="titulo">
                        </div>

                        <div class="form-datos">
                            <label for="descripcion">Descripcion:</label>
                            <input type="text" id="descripcion" name="descripcion">
                        </div>

                        <div class="form-datos">
                            <label for="cantidad">Cantidad:</label>
                            <input type="text" id="cantidad" name="cantidad">
                        </div>

                        <div class="form-datos">
                            <label for="fecha_inicio">Fecha Inicio:</label>
                            <input type="text" id="fecha_inicio" name="fecha_inicio">
                        </div>

                        <div class="form-datos">
                            <label for="fecha_fin">Fecha Fin:</label>
                            <input type="text" id="fecha_fin" name="fecha_fin">
                        </div>
                        
                        <!--
                        <label for="descuento_precio">Mostrar el descuento del precio</label>
                        <input type="checkbox" id="descuento_precio" name="descuento_precio">

                        <div class="form-card" id="div_precio">
                            <span class="card-data">El numero de los precios con dos decimales y separados por puntos</span>
                            <span class="card-data">Ejemplo: 2.40 | 5.00 </span>
                            </br>

                            <label for="descuento_precio_normal">Precio normal:</label>
                            <input type="text" id="descuento_precio_normal" name="descuento_precio_normal" value="15.99">

                            <label for="descuento_precio_rebajado">Precio con descuento:</label>
                            <input type="text" id="descuento_precio_rebajado" name="descuento_precio_rebajado" value="9.99">
                        </div>

                        <label for="descuento_porcentaje">Mostrar el descuento en porcentaje</label>
                        <input type="checkbox" id="descuento_porcentaje" name="descuento_porcentaje">

                        <div class="form-card" id="div_porcentaje">
                            <span class="card-data">El numero de los porcentajes poner solo el numero</span>
                            <span class="card-data">Ejemplo: 25 | 50 </span>
                            </br>
                            <label for="descuento_porcentaje_numero">Porcentaje de descuento:</label>
                            <input type="text" id="descuento_porcentaje_numero" name="descuento_porcentaje_numero"
                                value="25">
                        </div>
                        -->

                        </br>

                        <button type="submit" class="editar-cupon-btn" id="editar-cupon-final-btn" data-id="" >Editar Oferta</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmarBorradoModal" tabindex="-1" role="dialog" aria-labelledby="confirmarBorradoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmarBorradoModalLabel">Confirmar borrado</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas borrar este elemento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmarBorrado">Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php

}

