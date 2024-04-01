<?php

function usuarios_lista_ofertas_shortcode(){

    $ofertas = getOfertas();

    ?>
        <h1>Ofertas Disponibles</h1> 
        <div class="containerBack">
    <?php
    foreach($ofertas as $oferta){
        //var_dump($oferta); 
        $foto = ($oferta->foto != NULL) ? $oferta->foto : get_user_meta(get_current_user_id(), 'logotipo', true) ;
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
    ?> </div> <?php
    
}
add_shortcode('usuarios_lista_ofertas', 'usuarios_lista_ofertas_shortcode');
