<?php

function crear_oferta_shortcode() {

    ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
        }

        #myModal {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        jQuery(document).ready(function(){
            jQuery('#ilimitado').change(function(){
                if(this.checked){
                    jQuery('#quantity').hide(); // Oculta el input de cantidad
                    jQuery('label[for="quantity"]').hide(); // Oculta la etiqueta del input de cantidad
                } else {
                    jQuery('#quantity').show(); // Muestra el input de cantidad
                    jQuery('label[for="quantity"]').show(); // Muestra la etiqueta del input de cantidad
                }
            });

            jQuery('#descuento_precio').change(function(){
                if(this.checked){
                    jQuery('#div_precio').show(); // Muestra el input de cantidad
                    jQuery('#div_porcentaje').hide(); // Oculta el input de cantidad
                    jQuery('#descuento_porcentaje').prop('checked', false);
                } else {
                    jQuery('#div_precio').hide(); // Oculta el input de cantidad
                }
            });

            jQuery('#descuento_porcentaje').change(function(){
                if(this.checked){
                    jQuery('#div_porcentaje').show(); // Muestra el input de cantidad
                    jQuery('#div_precio').hide(); // Oculta el input de cantidad
                    jQuery('#descuento_precio').prop('checked', false);
                } else {
                    jQuery('#div_porcentaje').hide(); // Oculta el input de cantidad
                }
            });

            jQuery('#descuento_precio').change(function(){
                if(this.checked){
                    jQuery("#cardPrice").text("15.99€");
                    jQuery("#cardDescount").text("9.99€");
                    jQuery("#cardPrice").show();
                    jQuery("#cardDescount").show();
                } else {
                    jQuery("#cardPrice").text("");
                    jQuery("#cardDescount").text("");
                    jQuery("#cardPrice").hide();
                    jQuery("#cardDescount").hide();
                    
                }
            });

            jQuery('#descuento_porcentaje').change(function(){
                if(this.checked){
                    jQuery("#cardPrice").hide();
                    jQuery("#cardDescount").text("25%");
                    jQuery("#cardDescount").show();
                } else {
                    jQuery("#cardPrice").text("");
                    jQuery("#cardDescount").text("");
                    jQuery("#cardPrice").hide();
                    jQuery("#cardDescount").hide();
                }
            });

            jQuery('#descuento_precio_normal').on('input', function(){
                var actualValue = jQuery("#descuento_precio_normal").val();
                jQuery("#cardPrice").text(actualValue + "€");
            });

            jQuery('#descuento_precio_rebajado').on('input', function(){
                var actualValue = jQuery("#descuento_precio_rebajado").val();
                jQuery("#cardDescount").text(actualValue + "€");
            });

            jQuery('#descuento_porcentaje_numero').on('input', function(){
                var actualValue = jQuery("#descuento_porcentaje_numero").val();
                jQuery("#cardDescount").text(actualValue + "%");
            });

            jQuery('#offer-form').submit(function(e){
                e.preventDefault(); // Evita que el formulario se envíe normalmente
                
                var titulo = jQuery("#title").val();
                var descripcion = jQuery("#description").val();
                var fecha_inicio = jQuery("#fecha_inicial").val();
                var fecha_fin = jQuery("#fecha_fin").val();
                if(jQuery("#ilimitado").checked){
                    var cantidad = -1;
                } else {
                    var cantidad = jQuery("#quantity").val();
                };

                jQuery("#cardTitle").text(titulo);
                jQuery("#cardDescription").text(descripcion);
                jQuery("#form_cantidad").val(cantidad);
                jQuery("#form_fecha_inicio").val(fecha_inicio);
                jQuery("#form_fecha_fin").val(fecha_fin);

                // Abre la ventana modal
                jQuery('#myModal').modal('show');
            });

            jQuery('#inputFile').on('change', function() {
                // Obtener el objeto de archivo seleccionado
                var file = this.files[0];
                
                // Crear un objeto URL para la imagen cargada
                var imageUrl = URL.createObjectURL(file);
                
                // Establecer la URL de la imagen cargada como el valor del atributo src de la imagen
                jQuery('#cardImg').attr('src', imageUrl);
            });

            jQuery('#resetFoto').on('click', function() {
                // Limpiar el valor del campo de entrada de tipo archivo
                jQuery('#inputFile').val('');
                // Establecer la imagen de la URL predeterminada o vacía
                jQuery('#cardImg').attr('src', '<?php echo get_user_meta(get_current_user_id(), 'logotipo', true); ?>');
            });
        });
    </script>
    <div class="contenedor">
        <h2>Crear Nueva Oferta</h2>
        <form id="offer-form">
            <div class="form-datos">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
            </div>

            <div class="form-datos">
                <label for="description">Descripción:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <!-- pa luego
            <div class="form-datos">
                <label for="category">Categoría:</label>
                <select id="category" name="category" required>
                    <option value="">Seleccionar...</option>
                    <option value="tecnologia">Tecnología</option>
                    <option value="ropa">Ropa</option>
                    <option value="hogar">Hogar</option>
                    <option value="otros">Otros</option>
                </select>
            </div>
            -->

            <div class="form-datos">
                <label for="ilimitado">Cantidad ilimitada hasta que acabe la oferta</label>
                <input type="checkbox" id="ilimitado" name="ilimitado">

                <label for="quantity">Cantidad disponible:</label>
                <input type="number" id="quantity" name="quantity">
            </div>

            <div class="form-datos">
                <label for="fecha_inicial">Fecha inicial:</label>
                <input type="date" id="fecha_inicial" name="fecha_inicial" required>
            </div>

            <div class="form-datos">
                <label for="fecha_fin">Fecha fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" required>
            </div>

            <button type="submit" class="crear-oferta-btn">Crear Oferta</button>
        </form>
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
                    <form id="offer-data-form">

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
                            <input type="text" id="descuento_porcentaje_numero" name="descuento_porcentaje_numero" value="25">
                        </div>
                        
                        </br>

                            <label for="inputFile">Foto de oferta:</label>
                            <input type="file" id="inputFile" accept="image/*">

                        </br>
                        <input type="button" class="reset-btn" id="resetFoto" value="Resetear Foto">

                        </br></br>

                        <div class="containerBack">
                            <div class="cardBack">
                                <img src="<?php echo get_user_meta(get_current_user_id(), 'logotipo', true); ?>" id="cardImg" alt="Oferta 1">
                                <div class="card-content">
                                    <h2 class="card-title" id="cardTitle"></h2>
                                    <p class="card-description" id="cardDescription"></p>
                                    <p class="card-price" id="cardPrice"></p>
                                    <p class="card-descount" id="cardDescount"></p>
                                </div>
                            </div>
                        </div>

                        </br></br>

                        <input type="hidden" id="form_cantidad" name="form_cantidad">
                        <input type="hidden" id="form_fecha_inicio" name="form_fecha_inicio">
                        <input type="hidden" id="form_fecha_fin" name="form_fecha_fin">
                        <button type="submit" class="crear-oferta-btn">Crear Oferta</button>
                    </form>
                </div>
        
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
        
            </div>
        </div>
    </div>
    <?php
}
add_shortcode('crear_oferta', 'crear_oferta_shortcode');