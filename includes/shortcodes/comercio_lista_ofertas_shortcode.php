<?php

function comercio_lista_ofertas_shortcode() {
    // Asegurarse de que el usuario esté conectado
    if (!is_user_logged_in()) {
        return 'Debes iniciar sesión para ver las ofertas.';
    }

    // Obtener las ofertas del usuario actual
    $ofertas_usuario = getOfertaByIdAsociado(get_current_user_id());

    ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            jQuery(document).ready(function () {

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
    
    // Construir la tabla de ofertas
    $output = '<table class="ofertas-table">';
    $output .= '<tr><th>#</th><th>Titulo</th><th>Descripción</th><th>Cantidad restante</th><th>Precio Normal</th><th>Precio Rebajado</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Acciones</th></tr>';
    $contador = 1;

    foreach ($ofertas_usuario as $oferta) {

        $cantidad = ($oferta->cantidad == -1) ? "Ilimitado" : $oferta->cantidad;

        $output .= '<tr>';
        $output .= '<td>' . $contador . '</td>';
        $output .= '<td>' . esc_html($oferta->titulo) . '</td>';
        $output .= '<td>' . esc_html($oferta->descripcion) . '</td>';
        $output .= '<td>' . esc_html($cantidad) . '</td>';
        $output .= '<td>' . esc_html($oferta->precio_normal) . '</td>';
        $output .= '<td>' . esc_html($oferta->precio_rebajado) . '</td>';
        $output .= '<td>' . esc_html($oferta->fecha_inicio) . '</td>';
        $output .= '<td>' . esc_html($oferta->fecha_fin) . '</td>';
        $output .= '<td><button type="button" class="borrar-cupon-btn btn btn-danger" id="borrar-cupon-btn"
            data-id="' . $oferta->getId() . '" data-toggle="modal" data-target="#confirmarBorradoModal">Borrar</button>
            </td>';
        $output .= '</tr>';

        $contador++;
    }

    $output .= '</table>';

    return $output;
}
add_shortcode('comercio_lista_ofertas', 'comercio_lista_ofertas_shortcode');