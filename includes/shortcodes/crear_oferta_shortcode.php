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
            $('#ilimitado').change(function(){
                if(this.checked){
                    jQuery('#quantity').hide(); // Oculta el input de cantidad
                    jQuery('label[for="quantity"]').hide(); // Oculta la etiqueta del input de cantidad
                } else {
                    jQuery('#quantity').show(); // Muestra el input de cantidad
                    jQuery('label[for="quantity"]').show(); // Muestra la etiqueta del input de cantidad
                }
            });

            jQuery('#offer-form').submit(function(e){
                e.preventDefault(); // Evita que el formulario se envíe normalmente
                
                // Abre la ventana modal
                jQuery('#myModal').modal('show');
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
                    <h4 class="modal-title">Ventana Modal</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
        
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="card">
                        <img src="https://via.placeholder.com/300x200" alt="Oferta 1">
                        <div class="card-content">
                            <h2 class="card-title">Oferta 1</h2>
                            <p class="card-description">Descripción de la oferta 1.</p>
                            <p class="card-price">$19.99</p>
                        </div>
                    </div>
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