<?php

function usuarios_lista_ofertas_shortcode(){

    $ofertas_canjeadas = getOfertasCanjeadasByUserId(get_current_user_id(), false);
    $ofertas_sin_canjear = getOfertasSinCanjear(getOfertasCanjeadasByUserId(get_current_user_id()));

    ?>
        <script>

            jQuery(document).ready(function() {
                jQuery('.boton-oferta').click(function() {
                    var id = jQuery(this).data('id'); // Obtiene el texto del botón
                    var user_id = jQuery(this).data('user-id');

                    jQuery.ajax({
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'asignar_oferta_usuario',
                            id: id, // Envía el texto del botón como datos adicionales
                            user_id: user_id
                        },
                        success: function(response) {
                            // Maneja la respuesta si es necesaria
                            if(!response.error){
                                alert("holita");
                            }else{
                                alert("adiosito");
                            }
                            
                        },
                        error: function(error) {
                            // Maneja el error si es necesario
                            
                        }
                    });
                });
            });

        </script>   
        <h1>Ofertas Disponibles</h1> 
        <div class="containerBack">
    <?php
    foreach($ofertas_sin_canjear as $oferta){
        $foto = ($oferta->foto != NULL) ? $oferta->foto : get_user_meta($oferta->idAsociado, 'logotipo', true) ;
        $precio_normal = ($oferta->precio_normal != "0.00") ? '<p class="card-price" id="cardPrice">' . $oferta->precio_normal . '€</p>' : "";
        $precio_rebajado = ($oferta->precio_normal != "0.00") ? '<p class="card-descount" id="cardDescount">' . $oferta->precio_rebajado . '€</p>' : '<p class="card-descount" id="cardDescount">' . intval($oferta->precio_rebajado) . '%</p>' ;
        ?>
            
                <div class="cardBack">
                    <img src="<?php echo $foto; ?>" id="cardImg">
                    <div class="card-content">
                        <h2 class="card-title" id="cardTitle"><?php echo $oferta->titulo; ?></h2>
                        <p class="card-description" id="cardDescription"><?php echo $oferta->descripcion; ?></p>
                        <?php echo $precio_normal; ?>
                        <?php echo $precio_rebajado; ?>
                    </div>
                </div>
            
        <?php
    }
    ?> 
        </div>

        </br>

        <h2>Ofertas Canjeadas</h2> 
        <div class="containerBack">
    <?php
    foreach($ofertas_canjeadas as $oferta_canjeada){
        $foto = ($oferta_canjeada->foto != NULL) ? $oferta_canjeada->foto : get_user_meta(get_current_user_id(), 'logotipo', true) ;
        $precio_normal = ($oferta_canjeada->precio_normal != "0.00") ? '<p class="card-price" id="cardPrice">' . $oferta_canjeada->precio_normal . '€</p>' : "";
        $precio_rebajado = ($oferta_canjeada->precio_normal != "0.00") ? '<p class="card-descount" id="cardDescount">' . $oferta_canjeada->precio_rebajado . '€</p>' : '<p class="card-descount" id="cardDescount">' . intval($oferta_canjeada->precio_rebajado) . '%</p>' ;
        ?>
            
                <div class="cardBack">
                    <img src="<?php echo $foto; ?>" id="cardImg">
                    <div class="card-content">
                        <h2 class="card-title" id="cardTitle"><?php echo $oferta_canjeada->titulo; ?></h2>
                        <p class="card-description" id="cardDescription"><?php echo $oferta_canjeada->descripcion; ?></p>
                        <?php echo $precio_normal; ?>
                        <?php echo $precio_rebajado; ?>
                        <button class="boton-oferta" data-id="<?php echo $oferta_canjeada->id; ?>" data-user-id="<?php echo get_current_user_id(); ?>">Canjear oferta</button>
                    </div>
                </div>
            
        <?php
    }
    ?> </div> <?php
    
}
add_shortcode('usuarios_lista_ofertas', 'usuarios_lista_ofertas_shortcode');
