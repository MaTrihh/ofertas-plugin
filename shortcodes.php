<?php

//Crear usuario tarjeta
function registro_usuario_puntos_formulario_form()
{
    ?>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="checkbox"] {
            width: 20px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        h4 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .checkbox-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .checkbox-label {
            display: inline-block;
            margin-left: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            color: #000;
            /* Hace que el texto sea completamente negro */
            font-size: 12px;
            /* Ajusta el tamaño de la fuente según sea necesario */
            font-weight: normal;
            /* Puede ser 'normal' o 'bold' según prefieras */
            line-height: 1.4;
            /* Ajusta el espacio entre líneas para mejorar la legibilidad */
        }
    </style>

    <?php ob_start(); ?>

    <h2>Registro Tarjeta Puntos</h2>

    <form id="registro-form" action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" required>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" required>

        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" id="telefono" maxlength="9" required>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" id="direccion" required>

        <label for="localidad">Localidad:</label>
        <input type="text" name="localidad" id="localidad" required>

        <p>Lea las <a href="https://alcalacentro.es/aviso-legal/" target="_blank">bases legales</a> y la <a
                href="https://alcalacentro.es/politica-privacidad/" target="_blank">política de privacidad</a></p>

        <p>
            Por la presente, se le indica que la Unión de empresarios de Alcalá es el Responsable del tratamiento de los
            datos personales proporcionados y le informa de que estos datos serán tratados de conformidad con lo dispuesto
            en el Reglamento (UE) 2016/679, de 27 de abril (GDPR), y la Ley Orgánica 3/2018, de 5 de diciembre (LOPDGDD), la
            finalidad de la petición de sus datos personales es la correcta comprobación de sus datos. La legitimación es el
            CONSENTIMIENTO del interesado. Sus datos serán conservados durante no más tiempo del necesario para mantener el
            fin del tratamiento o mientras existan prescripciones legales que dictaminen su custodia. No se comunicarán los
            datos a terceros, salvo obligación legal. Asimismo, se le informa de que puede ejercer los derechos de acceso,
            rectificación, portabilidad y supresión de sus datos y los de limitación y oposición a su tratamiento,
            adjuntando copia de su DNI o documento equivalente, dirigiéndose a Unión de empresarios de Alcalá en C/ del
            Pradillo, 4 – 23680 Alcalá la Real (Jaén) o en el email: uniondeempresarios@dealcala.es y el de reclamación ante
            la autoridad nacional de control dirigiéndose a estos efectos a la Agencia Española de Protección de Datos <a
                href="https://www.aepd.es" target="_blank">www.aepd.es</a>.
        </p>

        <div class="checkbox-container">
            <input type="checkbox" id="bases_legales" name="bases_legales" required>
            <label for="bases_legales" class="checkbox-label">
                He leído y acepto las bases legales y la política de privacidad
            </label>
        </div>

        <input type="submit" value="Registrarse">
    </form>

    <script>
        jQuery(document).ready(function ($) {
            $('#registro-form').validate({
                rules: {
                    nombre: 'required',
                    apellidos: 'required',
                    correo: {
                        required: true,
                        email: true
                    },
                    dni: 'required',
                    telefono: 'required',
                    direccion: 'required',
                    localidad: 'required',
                    bases_legales: 'required'
                },
                messages: {
                    nombre: 'Por favor, introduce tu nombre',
                    apellidos: 'Por favor, introduce tus apellidos',
                    correo: {
                        required: 'Por favor, introduce tu correo electrónico',
                        email: 'Por favor, introduce una dirección de correo electrónico válida'
                    },
                    dni: 'Por favor, introduce tu DNI',
                    telefono: 'Por favor, introduce tu teléfono',
                    direccion: 'Por favor, introduce tu dirección',
                    localidad: 'Por favor, introduce tu localidad',
                    bases_legales: 'Por favor, acepte las bases legales y la politica de privacidad'
                },
                submitHandler: function (form) {
                    // Crear un nuevo usuario de WordPress y almacenar metadatos
                    var datosFormulario = $(form).serialize();
                    $.post(ajaxurl, { action: 'crear_usuario_tarjeta_puntos', datos: datosFormulario }, function (response) {
                        if (response.success) {
                            alert('¡Registro exitoso! Te mandaremos un correo cuando tu confirmemos tu tarjeta');
                            form.reset();
                        } else {
                            if (response.errors && response.errors.length > 0) {
                                alert('Error al validar el formulario:\n' + response.errors.join('\n'));
                            } else {
                                alert('Error al crear el usuario. Por favor, inténtalo de nuevo.');
                            }
                        }
                    }, 'json');
                }
            });
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('registro_usuario_puntos_formulario', 'registro_usuario_puntos_formulario_form');

function crear_usuario_tarjeta_puntos()
{
    // Obtener datos del formulario
    parse_str($_POST['datos'], $datos);

    // Crear un nuevo usuario
    $usuario_id = wp_insert_user(
        array(
            'user_login' => $datos['dni'],
            'user_pass' => $datos['telefono'], // Puedes usar cif como contraseña, cambia si es necesario
            'user_email' => $datos['correo'],
            'first_name' => $datos['nombre'] . ' ' . $datos['apellidos'],
            'role' => 'usuario_tarjeta_sin_verificar',
        )
    );

    // Verificar si se creó correctamente
    if (is_wp_error($usuario_id)) {
        echo json_encode(array('success' => false, 'errors' => array('Error al crear el usuario: ' . $usuario_id->get_error_message())));
        wp_die();
    }

    // Almacenar metadatos adicionales
    update_user_meta($usuario_id, 'telefono', sanitize_text_field($datos['telefono']));
    update_user_meta($usuario_id, 'direccion', sanitize_text_field($datos['direccion']));
    update_user_meta($usuario_id, 'localidad', sanitize_text_field($datos['localidad']));
    update_user_meta($usuario_id, 'first_name', sanitize_text_field($datos['nombre']));
    update_user_meta($usuario_id, 'last_name', sanitize_text_field($datos['apellidos']));
    update_user_meta($usuario_id, 'dni', sanitize_text_field($datos['dni']));
    update_user_meta($usuario_id, 'bases_legales', true);
    update_user_meta($usuario_id, 'numero_tarjeta', addNumTarjeta());

    echo json_encode(array('success' => true));

    // Importante: detener la ejecución después de enviar la respuesta
    wp_die();
}
// Función para manejar la creación de usuario en el servidor
add_action('wp_ajax_crear_usuario_tarjeta_puntos', 'crear_usuario_tarjeta_puntos');
add_action('wp_ajax_nopriv_crear_usuario_tarjeta_puntos', 'crear_usuario_tarjeta_puntos');

//Pasar de usuario dealcala a usuario puntos
function subir_usuario_dealcala_form()
{
    ?>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="checkbox"] {
            width: 20px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        h4 {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .checkbox-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .checkbox-label {
            display: inline-block;
            margin-left: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            color: #000;
            /* Hace que el texto sea completamente negro */
            font-size: 12px;
            /* Ajusta el tamaño de la fuente según sea necesario */
            font-weight: normal;
            /* Puede ser 'normal' o 'bold' según prefieras */
            line-height: 1.4;
            /* Ajusta el espacio entre líneas para mejorar la legibilidad */
        }
    </style>

    <?php ob_start(); ?>

    <h2>Promoción a Tarjeta de Puntos</h2>

    <form id="registro-form" action="" method="post">

        <label for="dni">DNI:</label>
        <input type="text" name="dni" id="dni" required>
        <input type="hidden" name="user_id" id="user_id" value="<?php echo get_current_user_ID(); ?>">

        <p>Lea las <a href="https://alcalacentro.es/aviso-legal/" target="_blank">bases legales</a> y la <a
                href="https://alcalacentro.es/politica-privacidad/" target="_blank">política de privacidad</a></p>

        <p>
            Por la presente, se le indica que la Unión de empresarios de Alcalá es el Responsable del tratamiento de los
            datos personales proporcionados y le informa de que estos datos serán tratados de conformidad con lo dispuesto
            en el Reglamento (UE) 2016/679, de 27 de abril (GDPR), y la Ley Orgánica 3/2018, de 5 de diciembre (LOPDGDD), la
            finalidad de la petición de sus datos personales es la correcta comprobación de sus datos. La legitimación es el
            CONSENTIMIENTO del interesado. Sus datos serán conservados durante no más tiempo del necesario para mantener el
            fin del tratamiento o mientras existan prescripciones legales que dictaminen su custodia. No se comunicarán los
            datos a terceros, salvo obligación legal. Asimismo, se le informa de que puede ejercer los derechos de acceso,
            rectificación, portabilidad y supresión de sus datos y los de limitación y oposición a su tratamiento,
            adjuntando copia de su DNI o documento equivalente, dirigiéndose a Unión de empresarios de Alcalá en C/ del
            Pradillo, 4 – 23680 Alcalá la Real (Jaén) o en el email: uniondeempresarios@dealcala.es y el de reclamación ante
            la autoridad nacional de control dirigiéndose a estos efectos a la Agencia Española de Protección de Datos <a
                href="https://www.aepd.es" target="_blank">www.aepd.es</a>.
        </p>

        <div class="checkbox-container">
            <input type="checkbox" id="bases_legales" name="bases_legales" required>
            <label for="bases_legales" class="checkbox-label">
                He leído y acepto las bases legales y la política de privacidad
            </label>
        </div>

        <input type="submit" value="Registrarse">
    </form>

    <script>
        jQuery(document).ready(function ($) {
            $('#registro-form').validate({
                rules: {
                    dni: 'required',
                    bases_legales: 'required'
                },
                messages: {
                    dni: 'Por favor, introduce tu DNI',
                    bases_legales: 'Por favor, acepte las bases legales y la politica de privacidad'
                },
                submitHandler: function (form) {
                    // Crear un nuevo usuario de WordPress y almacenar metadatos
                    var datosFormulario = $(form).serialize();
                    $.post(ajaxurl, { action: 'subir_usuario_tarjeta_puntos', datos: datosFormulario }, function (response) {
                        if (response.success) {
                            alert('¡Registro exitoso! Te mandaremos un correo cuando tu confirmemos tu tarjeta');
                            form.reset();
                        } else {
                            if (response.errors && response.errors.length > 0) {
                                alert('Error al validar el formulario:\n' + response.errors.join('\n'));
                            } else {
                                alert('Error al crear el usuario. Por favor, inténtalo de nuevo.');
                            }
                        }
                    }, 'json');
                }
            });
        });
    </script>

    <?php
    return ob_get_clean();
}
add_shortcode('subir_usuario_dealcala', 'subir_usuario_dealcala_form');

function subir_usuario_tarjeta_puntos()
{
    // Obtener datos del formulario
    parse_str($_POST['datos'], $datos);
    $usuario_id = $datos['user_id'];

    $u = new WP_User($usuario_id);

    // Remove role
    $u->remove_role('usuario_dealcala');

    // Add role
    $u->add_role('usuario_tarjeta_sin_verificar');

    // Almacenar metadatos adicionales
    update_user_meta($usuario_id, 'dni', sanitize_text_field($datos['dni']));
    update_user_meta($usuario_id, 'bases_legales', true);
    update_user_meta($usuario_id, 'numero_tarjeta', addNumTarjeta());

    echo json_encode(array('success' => true));

    // Importante: detener la ejecución después de enviar la respuesta
    wp_die();
}
// Función para manejar la creación de usuario en el servidor
add_action('wp_ajax_subir_usuario_tarjeta_puntos', 'subir_usuario_tarjeta_puntos');
add_action('wp_ajax_nopriv_subir_usuario_tarjeta_puntos', 'subir_usuario_tarjeta_puntos');

//---------------------------------------------
function cmp($a, $b)
{
    return strcmp($a->display_name, $b->display_name);
}

function subir_ticket_form()
{

    if (is_user_logged_in()) {
        if (current_user_can('usuario_tarjeta')) {

            $comercios_asociados = get_users(array('role' => 'comercio_asociado'));

            usort($comercios_asociados, 'cmp');
            ?>

            <script>
                jQuery(document).ready(function ($) {
                    jQuery('#comercio_id').change(function () {
                        var user_idSeleccionado = $(this).val();

                        jQuery('#defecto').hide();
                        jQuery('#imagen1').hide();
                        jQuery('#label1').hide();

                        jQuery('#imagen2').hide();
                        jQuery('#label2').hide();

                        jQuery('#imagen3').hide();
                        jQuery('#label3').hide();

                        jQuery('#imagen-container').show();
                        jQuery('#preview').attr('src', "https://alcalacentro.es/wp-content/plugins/puntos-por-compras/tickets_fotos/gif.gif");
                        jQuery('#preview').show();
                        // Realiza una llamada AJAX a la función PHP para obtener las rutas de imágenes asociadas al ID de usuario seleccionado
                        jQuery.ajax({
                            url: ajaxurl, // El ajax_url de WordPress
                            type: 'POST',
                            data: {
                                action: 'obtener_rutas_de_imagenes', // Nombre de la acción de WordPress
                                user_id: user_idSeleccionado // ID de usuario que se enviará como parámetro a la función PHP
                            },
                            success: function (response) {

                                var tickets = response.tickets;
                                var numeros = response.numeros;

                                var todasVacias = tickets.every(function (url) {
                                    return url === ""; // Comprueba si cada elemento es una cadena vacía
                                });

                                if (!todasVacias) {
                                    jQuery('#imagen1').attr('src', tickets[0]);
                                    jQuery('#imagen2').attr('src', tickets[1]);
                                    jQuery('#imagen3').attr('src', tickets[2]);

                                    jQuery('#preview').hide();

                                    if (tickets[0] != "") {
                                        jQuery('#imagen1').show();
                                        jQuery('#label1').show();
                                        jQuery('#span1').html('<strong>' + numeros[0] + '</strong>');
                                    } else {
                                        jQuery('#imagen1').hide();
                                        jQuery('#label1').hide();
                                    }

                                    if (tickets[1] != "") {
                                        jQuery('#imagen2').show();
                                        jQuery('#label2').show();
                                        jQuery('#span2').html('<strong>' + numeros[1] + '</strong>');
                                    } else {
                                        jQuery('#imagen2').hide();
                                        jQuery('#label2').hide();
                                    }

                                    if (tickets[2] != "") {
                                        jQuery('#imagen3').show();
                                        jQuery('#label3').show();
                                        jQuery('#span3').html('<strong>' + numeros[2] + '</strong>');
                                    } else {
                                        jQuery('#imagen3').hide();
                                        jQuery('#label3').hide();
                                    }
                                } else {
                                    jQuery('#preview').hide();
                                    jQuery('#defecto').show();
                                }

                            },
                            error: function (xhr, status, error) {
                                // Maneja errores de la solicitud AJAX
                                console.error(error); // Muestra errores en la consola para depuración
                            }
                        });
                    });
                });
            </script>

            <style>
                body {
                    font-family: Arial, sans-serif;
                }

                form {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background-color: #f9f9f9;
                }

                label {
                    display: block;
                    margin-bottom: 8px;
                }

                input[type="checkbox"] {
                    width: 20px;
                }

                input {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 16px;
                    box-sizing: border-box;
                }

                h4 {
                    margin-top: 20px;
                    margin-bottom: 10px;
                }

                .checkbox-container {
                    margin-bottom: 20px;
                    display: flex;
                    align-items: center;
                }

                .checkbox-label {
                    display: inline-block;
                    margin-left: 10px;
                }

                input[type="submit"] {
                    background-color: #4caf50;
                    color: #fff;
                    padding: 10px 15px;
                    border: none;
                    border-radius: 3px;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background-color: #45a049;
                }

                p {
                    color: #000;
                    /* Hace que el texto sea completamente negro */
                    font-size: 12px;
                    /* Ajusta el tamaño de la fuente según sea necesario */
                    font-weight: normal;
                    /* Puede ser 'normal' o 'bold' según prefieras */
                    line-height: 1.4;
                    /* Ajusta el espacio entre líneas para mejorar la legibilidad */
                }

                #comercio_id {
                    margin-bottom: 7px;
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 16px;
                    box-sizing: border-box;
                }

                #imagen-container {
                    margin-top: 20px;
                    text-align: center;
                    /* Para centrar la lista de imágenes */
                }

                #imagen-container ul {
                    padding: 0;
                }

                #imagen-container li {
                    list-style: none;
                    width: 50%;
                    /* Ancho del 50% */
                    display: inline-block;
                    /* Mostrar en línea */
                }

                #imagen-container img {
                    max-width: 90%;
                    display: inline-block;
                }

                #imagen-container label {
                    display: inline-block;
                }

                #preview {
                    width: 20% !important;
                }
            </style>

            <h2>Subir Ticket</h2>

            <form id="comercio-asociado-antiguo-form" action="" method="post" enctype="multipart/form-data">
                <label for="comercio_id">Elije el Establecimiento:</label>
                <select name="comercio_id" id="comercio_id">
                    <option value="0" disabled selected>SELECCIONA COMERCIO</option>
                    <?php
                    foreach ($comercios_asociados as $comercio) {
                        $opciones_guardadas = get_user_meta($comercio->ID, 'opciones_formulario', true);
                        if (in_array('cuota_comercio10', $opciones_guardadas)) {
                            echo '<option value="' . esc_attr($comercio->ID) . '">' . esc_html($comercio->first_name) . '</option>';
                        }

                    }
                    ?>
                </select></br>

                <div id="imagen-container" style="display: none;">
                    <ul>
                        <li><img id="preview" src="" style="display: none;"></li>
                        <li>
                            <h4 id="defecto" style="display: none;">No hay ejemplos de este comercio<h4>
                        </li>
                        <li>
                            <label for="imagen1" id="label1" style="display: none;">Ejemplo 1: <span id="span1"></span></label>
                            <img id="imagen1" src="" alt="Imagen 1" style="display: none;">
                        </li>
                        <li>
                            <label for="imagen2" id="label2" style="display: none;">Ejemplo 2: <span id="span2"></span></label>
                            <img id="imagen2" src="" alt="Imagen 2" style="display: none;">
                        </li>
                        <li>
                            <label for="imagen3" id="label3" style="display: none;">Ejemplo 3: <span id="span3"></span></label>
                            <img id="imagen3" src="" alt="Imagen 3" style="display: none;">
                        </li>
                    </ul>
                </div>


                <label for="numero">Numero del ticket: (Poner Numeros, Letras y Simbolos, todo sin espacios)</label>
                <input type="text" name="numero" id="numero" required>

                <label for="precio">Precio del ticket:</label>
                <input type="number" id="precio" name="precio" step="any" pattern="\d+(\.\d{1,2})?" title="Precio del ticket"
                    required>

                <label for="foto">Foto del ticket (PNG, JPEG, JPG)</label>
                <input type="file" name="foto" id="foto" accept=".png, .jpeg, .jpg">

                <input type="hidden" name="id" id="id" value="<?php echo get_current_user_id(); ?>">

                <input type="submit" value="Subir Ticket">
            </form>

            <script>
                jQuery(document).ready(function ($) {

                    $.validator.addMethod('accept', function (value, element, param) {
                        // Obtener la extensión del archivo
                        var extension = value.split('.').pop().toLowerCase();
                        return this.optional(element) || $.inArray(extension, param.split(',')) !== -1;
                    }, $.validator.format('Por favor, selecciona un archivo con una de las extensiones siguientes: {0}'));


                    $('#comercio-asociado-antiguo-form').validate({
                        rules: {
                            numero: 'required',
                            precio: 'required',
                            foto: {
                                required: true,
                                accept: 'png,jpeg,jpg'
                            }
                        },
                        messages: {
                            numero: 'Por favor, introduce el numero del ticket',
                            precio: 'Por favor, introduce el precio del ticket',
                            foto: 'Por favor, introduce la foto del ticket'
                        },
                        submitHandler: function (form) {

                            var comercioSeleccionado = jQuery('#comercio_id').val();
                            console.log(comercioSeleccionado);


                            if (comercioSeleccionado === null) {
                                alert('Por favor, selecciona un comercio válido.');
                                return false; // Evitar el envío del formulario
                            } else {
                                var formData = new FormData(form);

                                formData.append('action', 'process_subir_ticket');


                                $.ajax({
                                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                    type: 'POST',
                                    data: formData,
                                    async: false,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    dataType: 'json',
                                    success: function (response) {
                                        // Maneja la respuesta del servidor aquí
                                        if (response.success) {
                                            alert('!Se ha subido tu ticket!, te mandaremos un correo cuando lo aprobemos');
                                            form.reset();
                                        } else {
                                            alert(response.message);
                                        }
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        // Maneja el error de la solicitud AJAX aquí
                                        console.log('Error: ' + textStatus);
                                    }
                                });
                            }
                        }
                    });
                });
            </script>
        <?php
        } else {
            echo '<h1>Acceso denegado</h1>';
            echo '</br>';
            echo '<a href="' . home_url() . '">Volver</a>';
        }
    } else {
        ?>
        <style>
            /* Estilos generales del formulario */
            #loginform {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #fff;
            }

            /* Estilos para los campos de entrada */
            #loginform input[type="text"],
            #loginform input[type="password"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                box-sizing: border-box;
            }

            /* Estilos para el botón de envío */
            #loginform input[type="submit"] {
                background-color: #0073e6;
                color: #fff;
                padding: 10px 15px;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }

            #loginform input[type="submit"]:hover {
                background-color: #005bb5;
            }

            /* Estilos para los mensajes de error */
            #loginform .login-error {
                color: #ff0000;
                margin-bottom: 15px;
            }
        </style>
        <?php
        // Obtén la URL actual
        $_SESSION['alcala_custom_redirect_url'] = home_url($_SERVER['REQUEST_URI']);

        // Muestra el formulario de inicio de sesión con un campo oculto para la URL
        ?>
        <form action="<?php echo wp_login_url(); ?>" id="loginform" method="post">
            <?php wp_login_form(); ?>
        </form>
        <?php

    }

}
add_shortcode('subir_ticket', 'subir_ticket_form');

function subir_foto_callback()
{

    $servername = "rdbms.strato.de";
    $username = "dbu2152616";
    $password = "alcala23680";
    $database = "dbs12375000";

    $user_id = $_POST['id'];
    $asociado_id = $_POST['comercio_id'];
    $numero_ticket = $_POST['numero'];
    $precio = $_POST['precio'];

    // Manejar el archivo enviado
    if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['foto']['name'];
        $file_tmp = $_FILES['foto']['tmp_name'];

        $nombre = generateNombre(8) . '.' . pathinfo($file_name)['extension'];

        // Mueve el archivo al directorio de carga
        move_uploaded_file($file_tmp, plugin_dir_path(__FILE__) . 'tickets/' . $nombre);

        // Obtén la URL del archivo subido
        $foto_url = plugin_dir_url(__FILE__) . 'tickets/' . $nombre;

        $puntos_pendientes = intval($precio);

        if ($puntos_pendientes > 100) {
            $puntos_pendientes = 100;
        }

        //Comprobar si ya existe una solicitud como esta
        $resultado = comprobarSolicitud($user_id, $asociado_id, $numero_ticket);

        //Si lo encontramos lo editamos, sino lo creamos
        if ($resultado != null) {
            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                echo json_encode(array('success' => false, 'message' => 'Error, intentelo más tarde'));
                die ("Conexión fallida: " . $conn->connect_error);
            }

            $sql = "UPDATE solicitudes_ticket 
        SET Estado = 'pendiente', 
            numero_ticket = '$numero_ticket',  -- Agregué comillas para el valor de cadena
            precio = $precio,                  -- No se requieren comillas para valores numéricos
            foto_url = '$foto_url',            -- Agregué comillas para el valor de cadena
            puntos_pendientes = $puntos_pendientes,  -- No se requieren comillas para valores numéricos
            fecha = NOW() 
        WHERE id = $resultado";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(array('success' => true));
            } else {
                $ruta_archivo = obtener_ruta_archivo_desde_url($foto_url);
                if ($ruta_archivo && file_exists($ruta_archivo)) {
                    unlink($ruta_archivo);
                }
                echo json_encode(array('success' => false, 'message' => 'Vuelve a intentarlo mas tarde'));

            }

            // Cerrar conexión
            $conn->close();

            wp_die();
        } else {
            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                echo json_encode(array('success' => false, 'message' => 'Error, intentelo más tarde'));
                die ("Conexión fallida: " . $conn->connect_error);
            }

            $restriccionPuntos = control_tickets($user_id, $asociado_id);

            $sql = "INSERT INTO solicitudes_ticket (user_id, asociado_id, numero_ticket, precio, foto_url, puntos_pendientes, Estado, fecha, CanjeoTienda, restriccionPuntos) 
                VALUES ('$user_id', '$asociado_id', '$numero_ticket', '$precio', '$foto_url', '$puntos_pendientes', 'pendiente', NOW(), 'NULL', '$restriccionPuntos')";

            if ($conn->query($sql) === TRUE) {
                registrar_ticket_control($user_id, $asociado_id);
                echo json_encode(array('success' => true));
            } else {
                $ruta_archivo = obtener_ruta_archivo_desde_url($foto_url);
                if ($ruta_archivo && file_exists($ruta_archivo)) {
                    unlink($ruta_archivo);
                }
                echo json_encode(array('success' => false, 'message' => 'Este ticket ya ha sido canjeado'));

            }

            // Cerrar conexión
            $conn->close();

            wp_die();
        }

    } else {
        echo json_encode(array('success' => false, 'message' => 'Error al subir la foto'));
    }

}
add_action('wp_ajax_process_subir_ticket', 'subir_foto_callback');
add_action('wp_ajax_nopriv_process_subir_ticket', 'subir_foto_callback');

function premios_total_shortcode()
{

    if (is_user_logged_in()) {
        $premios = getPremios();
        $user_id = get_current_user_id();
        $puntos_usuario = getPuntosById($user_id);
        $premio = comprobarPremioNuevo($user_id);

        ?>
        <style>
            body.overlay-active {
                overflow: hidden;
                /* Evita el desplazamiento del cuerpo mientras el banner está abierto */
            }

            /* Estilo general del contenedor */
            .premios-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                margin: 20px 0;
            }

            /* Estilo de cada premio */
            .premio {
                width: 300px;
                margin: 20px;
                padding: 15px;
                border: 1px solid #ccc;
                text-align: center;
                background-color: #f9f9f9;
                /* Fondo gris claro */
                border-radius: 10px;
                /* Bordes redondeados */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                /* Sombra suave */
            }

            /* Estilo para el nombre del premio */
            .nombre-premio {
                display: inline-block;
                font-size: 24px;
                /* Tamaño de la fuente */
                color: #333;
                /* Color del texto */
                margin-bottom: 10px;
                /* Espaciado inferior */
                /* Otros estilos que desees agregar */
            }

            /* Estilo para la información adicional */
            .premio p {
                margin: 8px 0;
                color: #666;
                /* Color del texto secundario */
            }

            /* Estilo para el texto "Este premio ya lo has canjeado" */
            .premio p strong.red {
                color: red;
            }

            /* Estilo para el texto "Puedes canjear este premio" */
            .premio p strong.green {
                color: green;
            }

            /* Estilo para el botón de canjeo */
            .canjear-btn {
                background-color: #4CAF50;
                /* Color de fondo verde */
                color: white;
                /* Color del texto */
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                /* Transición suave */
            }

            .canjear-btn:hover {
                background-color: #45a049;
                /* Color de fondo verde oscuro al pasar el ratón */
            }

            /* Estilo para el enlace "Más información" */
            .más-info {
                color: #007bff;
                /* Color del texto azul */
                text-decoration: none;
                transition: color 0.3s ease;
                /* Transición suave */
            }

            .más-info:hover {
                color: #0056b3;
                /* Color del texto azul oscuro al pasar el ratón */
            }

            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                /* Fondo oscuro semi-transparente */
                display: none;
                /* Por defecto oculto */
                justify-content: center;
                align-items: center;
            }

            .banner {
                display: none;
                /* Por defecto oculto */
                position: relative;
                width: 90%;
                /* Utilizando un porcentaje del ancho de la pantalla */
                height: 90vh;
                /* Utilizando un porcentaje del alto de la pantalla */
                max-width: 90vh;
                /* Limitando el ancho máximo */
                max-height: 90vh;
                /* Limitando la altura máxima */
                padding: 10px;
                border-radius: 10px;
                /* Bordes redondeados */
                margin-top: 10%;
            }

            .close {
                position: absolute;
                top: 5px;
                right: 5px;
                color: white;
                /* Color del icono de la x */
                background-color: black;
                /* Color de fondo del icono de la x */
                border: none;
                cursor: pointer;
                border-radius: 50%;
                /* Hace que el botón tenga forma de círculo */
                padding: 5px;
                /* Aumenta el espacio alrededor del icono */
                z-index: 1;
                /* Asegura que el botón esté por encima del contenido */
            }

            .icono {
                width: 50px;
                /* Establece el ancho del icono */
                height: auto;
                /* Mantiene la proporción de aspecto */
                margin-left: 10px;
                /* Espacio entre el icono y el título */
                display: inline-block;
            }

            @media (max-width: 768px) {
                #bannerImage {
                    max-width: 100%;
                    /* La imagen ocupará el 100% del ancho disponible */
                    height: auto;
                    /* La altura se ajustará automáticamente según el ancho */
                    display: block;
                    /* Asegura que la imagen no tenga espacios en blanco debajo */
                    margin-left: 20px;
                }


            }
        </style>

        <div class="modal-overlay">
            <div class="banner">
                <img src="<?php echo !empty ($premio) ? $premio["foto"] : ""; ?>" id="bannerImage" alt="Banner Image">
                <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 25px;">&times;</span>
                </button>
            </div>
        </div>
        <?php

        if (!empty ($premio)) {
            ?>
            <script>
                jQuery(document).ready(function () {

                    jQuery(".modal-overlay").css("display", "flex");
                    jQuery('.banner').show(); // Mostrar la ventana modal al principio
                    jQuery('.modal-overlay').show();

                    jQuery('.close').click(function () {
                        jQuery('.banner').hide(); // Ocultar la ventana modal
                        jQuery('.modal-overlay').hide(); // Ocultar el fondo oscuro
                    });

                    // Mostrar el fondo oscuro cuando se muestra la ventana modal
                    jQuery('.banner').on('show.bs.modal', function () {
                        jQuery('.modal-overlay').show();
                    });
                });
            </script>
            <?php

            registrarFelicitacion($user_id, $premio['id_premio']);
        }

        ?>


        <div class="premios-container">
            <?php foreach ($premios as $premio): ?>
                <div class="premio">
                    <h2 class="nombre-premio">
                        <?php echo $premio['nombre']; ?>
                    </h2>
                    <?php echo ($premio['icono'] != "") ? '<img src="' . $premio['icono'] . '" alt="Icono" class="icono">' : ""; ?>
                    <p><strong>Coste de puntos:</strong>
                        <?php echo $premio['coste']; ?>
                    </p>
                    <p><strong>Descuento:</strong>
                        <?php echo $premio['descuento'] . '€'; ?>
                    </p>
                    <p><strong>Descripción:</strong>
                        <?php echo $premio['descripcion']; ?>
                    </p>
                    <?php if (buscarPremioUsado($user_id, $premio['id_premio']) == false): ?>
                        <p><strong class="red">Este premio ya lo has canjeado</strong></p>
                    <?php else: ?>
                        <?php if ($puntos_usuario > $premio['coste']): ?>
                            <p><strong class="green">Puedes canjear este premio</strong></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>


        <?php
    }
}
add_shortcode('premios_shortcode', 'premios_total_shortcode');

function premios_canjeados_tienda_shortcode()
{

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        jQuery(document).ready(function () {
            jQuery(".buscar-btn").on("click", function () {

                var dni = jQuery('#dni').val();
                var user_id;

                //Peticion AJAX para sacar el id del usuario
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "buscar_user", // Acción que indica qué función de PHP llamar
                        dni: dni
                    },
                    success: function (response) {
                        if (response.success) {
                            user_id = response.id;

                            //Peticion AJAX para sacar los premios del usuario
                            jQuery.ajax({
                                type: "POST",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: "comprobar_user", // Acción que indica qué función de PHP llamar
                                    user_id: user_id
                                },
                                success: function (response) {
                                    if (response.success) {

                                        jQuery('#user_id').val(user_id);
                                        var premios = response.premios;
                                        jQuery(".modal-body").empty();
                                        jQuery(".modal-header").text("Premios");

                                        // Construir la tabla

                                        var table = '<table class="table table-bordered table-striped">';
                                        table += '<thead class="thead-dark"><tr><th></th><th>Nombre Usuario</th><th>Nombre del Premio</th><th>Descuento</th></tr></thead>';
                                        table += '<tbody>';

                                        premios.forEach(function (premio, index) {

                                            table += '<tr>';
                                            table += '<td><input type="checkbox" name="premios_canjeado[]" value="' + premio.id_premio + '"></input></td>';
                                            table += '<td>' + premio.nombre_usuario + '</td>';
                                            table += '<td>' + premio.nombre + '</td>';
                                            table += '<td>' + premio.descuento + '€</td>';
                                            table += '</tr>';

                                        });

                                        table += '</tbody></table>';

                                        // Agregar la tabla al contenido de la modal
                                        jQuery(".modal-body").append(table);

                                        jQuery(".modal").modal("show");
                                    } else {
                                        alert("Este usuario no tiene premios");
                                    }
                                },
                                error: function (error) {
                                    // Manejar errores si los hay
                                    console.error(error);
                                }
                            });
                        } else {
                            alert("Este usuario no existe");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });

            });

            // Función que se ejecuta al hacer clic en el botón 'Canjear'
            jQuery('#miFormulario').submit(function (event) {

                // Evitar que el formulario se envíe
                event.preventDefault();

                // Crear un array para almacenar los valores de los checkboxes marcados
                var valoresCheckbox = [];

                // Recorrer los checkboxes marcados y agregar sus valores al array
                jQuery('#miFormulario input[type="checkbox"][name="premios_canjeado[]"]:checked').each(function () {
                    valoresCheckbox.push(jQuery(this).val());
                });

                var id_asociado = jQuery('#id_asociado').val();
                var user_id = jQuery('#user_id').val();

                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "usar_premio", // Acción que indica qué función de PHP llamar
                        valoresCheckbox: valoresCheckbox,
                        id_asociado: id_asociado,
                        user_id: user_id
                    },
                    success: function (response) {
                        if (response.success) {
                            alert("Canjeo con éxito");
                            location.reload();
                        } else {
                            alert("Ha habido algun error en el canjeo, pruebe mas tarde");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                })


                // Cierra la ventana modal
                jQuery('.modal').modal('hide');
            });
        });

    </script>

    <style>
        .div {
            font-family: Arial, sans-serif;
            margin-top: 15%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-canjear {
            margin-left: 3%;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>

    <div class="div">
        <form method="POST">
            <h2>Buscar Usuario:</h2>
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI" required>
            <button class="buscar-btn" type="button">Buscar</button>
        </form>
    </div>

    <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title" id="nombre"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <form id="miFormulario">
                    <!-- Contenido del Modal -->
                    <input type="hidden" name="id_asociado" id="id_asociado"
                        value="<?php echo get_current_user_id(); ?>"></input>
                    <input type="hidden" name="user_id" id="user_id"></input>
                    <div class="modal-body">




                    </div>

                    <button type="submit" class="btn btn-primary btn-canjear">Canjear</button>

                </form>
                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                </div>


            </div>
        </div>
    </div>

    <?php
}
add_shortcode('premios_canjeados_tienda', 'premios_canjeados_tienda_shortcode');

function regalar_puntos_tienda_shortcode()
{

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        jQuery(document).ready(function () {
            jQuery(".buscar-btn").on("click", function () {

                var dni = jQuery('#dni').val();
                var puntos_asociado = jQuery('#puntos_asociado').val();
                var user_id;

                //Peticion AJAX para sacar el id del usuario
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "buscar_user", // Acción que indica qué función de PHP llamar
                        dni: dni
                    },
                    success: function (response) {
                        if (response.success) {
                            user_id = response.id;
                            jQuery('#user_id').val(user_id);
                            jQuery('#nombre').text("Regalar puntos a: " + dni);
                            jQuery('#puntos_asociado_form').html("Tienes: " + puntos_asociado + " puntos");
                            jQuery(".modal").modal("show");

                        } else {
                            alert("Este usuario no existe");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });

            });

            // Función que se ejecuta al hacer clic en el botón 'Canjear'
            jQuery('#regalarPuntosForm').submit(function (event) {

                // Evitar que el formulario se envíe
                event.preventDefault();

                var id_asociado = jQuery('#id_asociado').val();
                var user_id = jQuery('#user_id').val();
                var puntos = jQuery('#puntos').val();

                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "regalar_puntos", // Acción que indica qué función de PHP llamar
                        puntos: puntos,
                        idAsociado: id_asociado,
                        user_id: user_id
                    },
                    success: function (response) {
                        if (response.success) {
                            alert("Regalo con éxito");
                            location.reload();
                        } else {
                            alert("Ha habido algun error en el canjeo, pruebe mas tarde");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                })


                // Cierra la ventana modal
                jQuery('.modal').modal('hide');
            });
        });

    </script>

    <style>
        .div {
            font-family: Arial, sans-serif;
            margin-top: 15%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-canjear {
            margin-left: 3%;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>

    <div class="div">
        <form method="POST">
            <h2>Buscar Usuario:</h2>
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI" required>
            <input type="hidden" id="puntos_asociado" value="<?php echo getPuntosAsociadosById(get_current_user_id()); ?>">
            <button class="buscar-btn" type="button">Buscar</button>
        </form>
    </div>

    <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title" id="nombre"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>


                <div class="modal-body">
                    <form id="regalarPuntosForm">
                        <div class="form-group">

                            <h4 class="modal-title" id="puntos_asociado_form"></h4>
                            <label for="puntos">Puntos:</label>
                            <input type="text" class="form-control" name="puntos" id="puntos"></input>
                            <input type="hidden" name="id_asociado" id="id_asociado"
                                value="<?php echo get_current_user_id(); ?>"></input>
                            <input type="hidden" name="user_id" id="user_id"></input>

                        </div>

                        <button type="submit" class="btn btn-primary btn-canjear">Regalar</button>

                    </form>
                </div>
                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                </div>


            </div>
        </div>
    </div>

    <?php
}
add_shortcode('regalar_puntos_tienda', 'regalar_puntos_tienda_shortcode');

function premios_canjeados_por_tienda_shortcode()
{

    $actual_id = get_current_user_id();
    $opciones_formulario = get_user_meta($actual_id, 'opciones_formulario', true);

    if ($opciones_formulario) {
        if (in_array('cuota_comercio10', $opciones_formulario)) {
            $premios_canjeados = getPremiosComercioId($actual_id);
            $contador = 1;

            ?>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <style>
                #tabla {
                    border-collapse: collapse;
                    width: 100%;
                    margin-top: 20px;
                }

                #tabla th,
                #tabla td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: center;
                }

                #tabla th {
                    background-color: #f2f2f2;
                    color: #333;
                }

                #tabla tbody tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                #tabla tbody tr:hover {
                    background-color: #ddd;
                }

                .container {
                    margin-top: 50px;
                }
            </style>

            <div class="container">
                <h2>Premios Canjeados</h2>
                <table class="table" id="tabla">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre del Premio</th>
                            <th>Descuento</th>
                            <th>DNI Usuario</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas de prueba -->
                        <?php
                        foreach ($premios_canjeados as $premio) {

                            $id_premio = $premio['id_premio'];
                            $id_usuario = $premio['id_usuario'];
                            $datos_premio = getPremioById($id_premio);
                            $user_data = get_userdata($id_usuario);

                            $nombre_premio = $datos_premio['nombre'];
                            $descuento = $datos_premio['descuento'];
                            $dni_usuario = $user_data->user_login;
                            $fecha = $premio['fecha'];
                            $estado = $premio['estado'];
                            ?>
                            <tr>
                                <td>
                                    <?php echo $contador; ?>
                                </td>
                                <td>
                                    <?php echo $nombre_premio; ?>
                                </td>
                                <td>
                                    <?php echo $descuento; ?>€
                                </td>
                                <td>
                                    <?php echo $dni_usuario; ?>
                                </td>
                                <td>
                                    <?php echo $fecha; ?>
                                </td>
                                <td>
                                    <?php echo $estado; ?>
                                </td>
                            </tr>
                            <?php
                            $contador++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>


            <?php
        }
    } else {
        echo "No tienes permisos para esta función";
    }




}
add_shortcode('premios_canjeados_por_tienda', 'premios_canjeados_por_tienda_shortcode');

function puntos_canjeados_usuario_shortcode()
{

    if (is_user_logged_in()) {
        $actual_id = get_current_user_id();
        $sql = "SELECT * FROM solicitudes_ticket WHERE user_id = $actual_id";

        $solicitudes = conseguirTodasSolicitudes($sql);
        $contador = 1;

        ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <style>
            #tabla {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
            }

            #tabla th,
            #tabla td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            #tabla th {
                background-color: #f2f2f2;
                color: #333;
            }

            #tabla tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #tabla tbody tr:hover {
                background-color: #ddd;
            }

            .container {
                margin-top: 50px;
            }
        </style>

        <div class="container">
            <h2>Puntos Canjeados</h2>
            <table class="table" id="tabla">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Comercio</th>
                        <th>Puntos Conseguidos</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Filas de prueba -->
                    <?php
                    foreach ($solicitudes as $solicitud) {

                        $comercio_data = get_userdata($solicitud['asociado_id']);
                        $comercio = $comercio_data->first_name . ' ' . $comercio_data->last_name;
                        $puntos_conseguidos = $solicitud['puntos_pendientes'];
                        $estado = $solicitud['Estado'];
                        $fecha = $solicitud['fecha'];

                        ?>
                        <tr>
                            <td>
                                <?php echo $contador; ?>
                            </td>
                            <td>
                                <?php echo $comercio; ?>
                            </td>
                            <td>
                                <?php echo $puntos_conseguidos; ?>
                            </td>
                            <td>
                                <?php echo $estado; ?>
                            </td>
                            <td>
                                <?php echo $fecha; ?>
                            </td>
                        </tr>
                        <?php
                        $contador++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    } else {
        echo "Inicia sesión para acceder aquí";
    }
}
add_shortcode('puntos_canjeados_usuario', 'puntos_canjeados_usuario_shortcode');

function crear_ticket_por_comercio_shortcode()
{
    if (is_user_logged_in()) {
        if (current_user_can('comercio_asociado')) {

            ?>

            <style>
                body {
                    font-family: Arial, sans-serif;
                }

                form {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    border: 1px solid #ddd;
                    border-radius: 5px;
                    background-color: #f9f9f9;
                }

                label {
                    display: block;
                    margin-bottom: 8px;
                }

                input[type="checkbox"] {
                    width: 20px;
                }

                input {
                    width: 100%;
                    padding: 8px;
                    margin-bottom: 16px;
                    box-sizing: border-box;
                }

                h4 {
                    margin-top: 20px;
                    margin-bottom: 10px;
                }

                .checkbox-container {
                    margin-bottom: 20px;
                    display: flex;
                    align-items: center;
                }

                .checkbox-label {
                    display: inline-block;
                    margin-left: 10px;
                }

                input[type="submit"] {
                    background-color: #4caf50;
                    color: #fff;
                    padding: 10px 15px;
                    border: none;
                    border-radius: 3px;
                    cursor: pointer;
                }

                input[type="submit"]:hover {
                    background-color: #45a049;
                }

                p {
                    color: #000;
                    /* Hace que el texto sea completamente negro */
                    font-size: 12px;
                    /* Ajusta el tamaño de la fuente según sea necesario */
                    font-weight: normal;
                    /* Puede ser 'normal' o 'bold' según prefieras */
                    line-height: 1.4;
                    /* Ajusta el espacio entre líneas para mejorar la legibilidad */
                }

                #comercio_id {
                    margin-bottom: 7px;
                }
            </style>

            <h2>Subir Ticket Comercio</h2>

            <form id="comercio-ticket-form" action="" method="post" enctype="multipart/form-data">

                <label for="dni">DNI Usuario:</label>
                <input type="text" name="dni" id="dni" required>

                <label for="numero">Numero del ticket:</label>
                <input type="text" name="numero" id="numero" required>

                <label for="precio">Precio del ticket:</label>
                <input type="number" id="precio" name="precio" step="any" pattern="\d+(\.\d{1,2})?" title="Precio del ticket"
                    required>

                <label for="foto">Foto del ticket (PNG, JPEG, JPG)</label>
                <input type="file" name="foto" id="foto" accept=".png, .jpeg, .jpg">

                <input type="hidden" name="id" id="id" value="<?php echo get_current_user_id(); ?>">

                <input type="submit" value="Subir Ticket">
            </form>

            <script>
                jQuery(document).ready(function ($) {

                    $.validator.addMethod('accept', function (value, element, param) {
                        // Obtener la extensión del archivo
                        var extension = value.split('.').pop().toLowerCase();
                        return this.optional(element) || $.inArray(extension, param.split(',')) !== -1;
                    }, $.validator.format('Por favor, selecciona un archivo con una de las extensiones siguientes: {0}'));


                    $('#comercio-ticket-form').validate({
                        rules: {
                            numero: 'required',
                            precio: 'required',
                            foto: {
                                required: true,
                                accept: 'png,jpeg,jpg'
                            }
                        },
                        messages: {
                            numero: 'Por favor, introduce el numero del ticket',
                            precio: 'Por favor, introduce el precio del ticket',
                            foto: 'Por favor, introduce la foto del ticket'
                        },
                        submitHandler: function (form) {

                            var formData = new FormData(form);

                            formData.append('action', 'process_subir_ticket_comercio');


                            $.ajax({
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                type: 'POST',
                                data: formData,
                                async: false,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function (response) {
                                    if (response.success === true) {
                                        alert('¡Se ha subido tu ticket! Te mandaremos un correo cuando lo aprobemos');
                                        form.reset();
                                    } else {
                                        alert(response.message);

                                    }
                                },
                                error: function (jqXHR, textStatus, errorThrown) {
                                    console.log('Error: ' + textStatus);
                                }
                            });
                        }
                    });
                });
            </script>
        <?php
        } else {
            echo '<h1>Acceso denegado</h1>';
            echo '</br>';
            echo '<a href="' . home_url() . '">Volver</a>';
        }
    } else {
        ?>
        <style>
            /* Estilos generales del formulario */
            #loginform {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #fff;
            }

            /* Estilos para los campos de entrada */
            #loginform input[type="text"],
            #loginform input[type="password"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                box-sizing: border-box;
            }

            /* Estilos para el botón de envío */
            #loginform input[type="submit"] {
                background-color: #0073e6;
                color: #fff;
                padding: 10px 15px;
                border: none;
                border-radius: 3px;
                cursor: pointer;
            }

            #loginform input[type="submit"]:hover {
                background-color: #005bb5;
            }

            /* Estilos para los mensajes de error */
            #loginform .login-error {
                color: #ff0000;
                margin-bottom: 15px;
            }
        </style>
        <?php
        // Obtén la URL actual
        $_SESSION['alcala_custom_redirect_url'] = home_url($_SERVER['REQUEST_URI']);

        // Muestra el formulario de inicio de sesión con un campo oculto para la URL
        ?>
        <form action="<?php echo wp_login_url(); ?>" id="loginform" method="post">
            <?php wp_login_form(); ?>
        </form>
        <?php

    }
}
add_shortcode('crear_ticket_por_comercio', 'crear_ticket_por_comercio_shortcode');

function subir_ticket_comercio_callback()
{

    $servername = "rdbms.strato.de";
    $username = "dbu2152616";
    $password = "alcala23680";
    $database = "dbs12375000";

    $asociado_id = $_POST['id'];
    $dni = $_POST['dni'];
    $numero_ticket = $_POST['numero'];
    $precio = $_POST['precio'];

    //Comprobar que el usuario existe
    $user = get_user_by('login', $dni);

    if ($user) {

        $user_id = $user->ID;

        // Ruta donde se guardarán las fotos
        $upload_dir = wp_upload_dir();
        $upload_path = $upload_dir['path'] . '/';

        // Manejar el archivo enviado
        if ($_FILES['foto']['error'] == UPLOAD_ERR_OK) {
            $file_name = $_FILES['foto']['name'];
            $file_tmp = $_FILES['foto']['tmp_name'];

            // Mueve el archivo al directorio de carga
            move_uploaded_file($file_tmp, $upload_path . $file_name);

            // Obtén la URL del archivo subido
            $foto_url = $upload_dir['url'] . '/' . $file_name;

            $puntos_pendientes = intval($precio);

            if ($puntos_pendientes > 100) {
                $puntos_pendientes = 100;
            }

            // Crear conexión
            $conn = new mysqli($servername, $username, $password, $database);

            // Verificar la conexión
            if ($conn->connect_error) {
                echo json_encode(array('success' => false, 'message' => 'Error, intentelo más tarde'));
                die ("Conexión fallida: " . $conn->connect_error);
            }

            $sql = "INSERT INTO solicitudes_ticket (user_id, asociado_id, numero_ticket, precio, foto_url, puntos_pendientes, estado, CanjeoTienda) 
                VALUES ('$user_id', '$asociado_id', '$numero_ticket', '$precio', '$foto_url', '$puntos_pendientes', 'pendiente', 1)";

            if ($conn->query($sql) === TRUE) {
                echo json_encode(array('success' => true));
            } else {
                $ruta_archivo = obtener_ruta_archivo_desde_url($foto_url);
                if ($ruta_archivo && file_exists($ruta_archivo)) {
                    unlink($ruta_archivo);
                }
                echo json_encode(array('success' => false, 'message' => 'Este ticket ya ha sido canjeado'));

            }

            // Cerrar conexión
            $conn->close();

            wp_die();

        } else {
            echo json_encode(array('success' => false, 'message' => 'Error al subir la foto'));
        }
    } else {
        wp_send_json(array('success' => false, 'message' => 'No existe el usuario'));
    }

}
add_action('wp_ajax_process_subir_ticket_comercio', 'subir_ticket_comercio_callback');
add_action('wp_ajax_nopriv_process_subir_ticket_comercio', 'subir_ticket_comercio_callback');

function crear_cupon_por_comercio_shortcode()
{

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .div {
            font-family: Arial, sans-serif;
            margin-top: 15%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-canjear {
            margin-left: 3%;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .modal {
            display: none;
        }
    </style>

    <script>
        jQuery(document).ready(function () {
            jQuery(".buscar-btn").on("click", function () {

                var dni = jQuery('#dni').val();
                var user_id;

                //Peticion AJAX para sacar el id del usuario
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "buscar_user", // Acción que indica qué función de PHP llamar
                        dni: dni
                    },
                    success: function (response) {
                        if (response.success) {
                            user_id = response.id;

                            //Peticion AJAX para sacar los premios del usuario
                            jQuery.ajax({
                                type: "POST",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: "comprobar_user_tarjeta", // Acción que indica qué función de PHP llamar
                                    user_id: user_id
                                },
                                success: function (response) {
                                    if (response.success) {

                                        //Sacar los datos de la fecha de inicio y del usuario y ponerlos en el input
                                        jQuery('#user_id').val(response.user_id)

                                        var fecha = new Date();

                                        // Obtener el año, mes y día
                                        var year = fecha.getFullYear();
                                        var month = ('0' + (fecha.getMonth() + 1)).slice(-2); // Agregar 1 al mes porque los meses comienzan desde 0
                                        var day = ('0' + fecha.getDate()).slice(-2);

                                        // Formatear la fecha en el formato YYYY-MM-DD
                                        var fechaHoy = year + '-' + month + '-' + day;

                                        jQuery('#fecha_inicio').val(fechaHoy);
                                        jQuery('#userDNI').val(dni);

                                        jQuery(".modal").modal("show");
                                    } else {
                                        alert("Este usuario no tiene tarjeta");
                                    }
                                },
                                error: function (error) {
                                    // Manejar errores si los hay
                                    console.error(error);
                                }
                            });
                        } else {
                            alert("Este usuario no existe");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });

            });

            // Función que se ejecuta al hacer clic en el botón 'Canjear'
            jQuery('#miFormulario').submit(function (event) {

                // Evitar que el formulario se envíe
                event.preventDefault();

                var id_asociado = jQuery('#id_asociado').val();
                var user_id = jQuery('#user_id').val();
                var titulo = jQuery('#titulo').val();
                var descripcion = jQuery('#descripcion').val();
                var fecha_inicio = jQuery('#fecha_inicio').val();
                var fecha_fin = jQuery('#fecha_final').val();
                var user_dni = jQuery('#userDNI').val();

                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "crear_cupon", // Acción que indica qué función de PHP llamar
                        titulo: titulo,
                        descripcion: descripcion,
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin,
                        idAsociado: id_asociado,
                        user_id: user_id,
                        dni: user_dni
                    },
                    success: function (response) {
                        if (response.success) {
                            alert("Creación con éxito");

                        } else {
                            alert("Ha habido algun error en el canjeo, pruebe mas tarde");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                })


                // Cierra la ventana modal
                jQuery('.modal').modal('hide');
            });
        });

    </script>

    <div class="div">
        <form method="POST">
            <h1>Crear Cupon</h1>
            <h2>Buscar Usuario:</h2>
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI" required>
            <button class="buscar-btn" type="button">Buscar</button>
        </form>
    </div>

    <div class="modal" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title" id="nombre">Datos del Cupón</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <form id="miFormulario">
                    <!-- Contenido del Modal -->
                    <input type="hidden" name="id_asociado" id="id_asociado"
                        value="<?php echo get_current_user_id(); ?>"></input>
                    <input type="hidden" name="user_id" id="user_id"></input>
                    <div class="modal-body">

                        <label for="titulo">Titulo del Cupón</label>
                        <input type="text" name="titulo" id="titulo"></input>

                        </br>

                        <label for="descripcion">Descripción del Cupón</label>
                        <input type="text" name="descripcion" id="descripcion"></input>

                        </br>

                        <label for="fecha_inicio">Fecha de Inicio del Cupón</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" />

                        </br>

                        <label for="fecha_final">Fecha de Final del Cupón</label>
                        <input type="date" name="fecha_final" id="fecha_final" />
                        <input type="hidden" name="userDNI" id="userDNI" />

                        </br>

                    </div>

                    <button type="submit" class="btn btn-primary btn-canjear">Crear</button>

                </form>
                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                </div>


            </div>
        </div>
    </div>
    <?php
}
add_shortcode('crear_cupon_por_comercio', 'crear_cupon_por_comercio_shortcode');

function canjeo_cupones_shortcode()
{

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        jQuery(document).ready(function () {
            jQuery(".buscar-btn").on("click", function () {

                var dni = jQuery('#dni').val();
                var user_id;

                //Peticion AJAX para sacar el id del usuario
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "buscar_user", // Acción que indica qué función de PHP llamar
                        dni: dni
                    },
                    success: function (response) {
                        if (response.success) {
                            user_id = response.id;

                            //Peticion AJAX para sacar los premios del usuario
                            jQuery.ajax({
                                type: "POST",
                                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                                data: {
                                    action: "comprobar_cupones_user", // Acción que indica qué función de PHP llamar
                                    user_id: user_id
                                },
                                success: function (response) {
                                    if (response.success) {

                                        jQuery('#user_id').val(user_id);
                                        var cupones = response.cupones;
                                        jQuery(".modal-body").empty();
                                        jQuery(".modal-header").text("Premios");

                                        // Construir la tabla

                                        var table = '<table class="table table-bordered table-striped">';
                                        table += '<thead class="thead-dark"><tr><th></th><th>Nombre Usuario</th><th>Nombre del Premio</th><th>Descripcion</th></tr></thead>';
                                        table += '<tbody>';

                                        cupones.forEach(function (cupon, index) {

                                            table += '<tr>';
                                            table += '<td><input type="checkbox" name="cupones_canjeado[]" value="' + cupon.id + '"></input></td>';
                                            table += '<td>' + cupon.nombre + '</td>';
                                            table += '<td>' + cupon.titulo + '</td>';
                                            table += '<td>' + cupon.descripcion + '</td>';
                                            table += '</tr>';

                                        });

                                        table += '</tbody></table>';

                                        // Agregar la tabla al contenido de la modal
                                        jQuery(".modal-body").append(table);

                                        jQuery(".modal").modal("show");
                                    } else {
                                        alert("Este usuario no tiene cupones");
                                    }
                                },
                                error: function (error) {
                                    // Manejar errores si los hay
                                    console.error(error);
                                }
                            });
                        } else {
                            alert("Este usuario no existe");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });

            });

            // Función que se ejecuta al hacer clic en el botón 'Canjear'
            jQuery('#miFormulario').submit(function (event) {

                // Evitar que el formulario se envíe
                event.preventDefault();

                // Crear un array para almacenar los valores de los checkboxes marcados
                var valoresCheckbox = [];

                // Recorrer los checkboxes marcados y agregar sus valores al array
                jQuery('#miFormulario input[type="checkbox"][name="cupones_canjeado[]"]:checked').each(function () {
                    valoresCheckbox.push(jQuery(this).val());
                });


                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "usar_cupon", // Acción que indica qué función de PHP llamar
                        valoresCheckbox: valoresCheckbox
                    },
                    success: function (response) {
                        if (response.success) {
                            alert("Canjeo con éxito");
                            location.reload();
                        } else {
                            alert("Ha habido algun error en el canjeo, pruebe mas tarde");
                        }
                    },
                    error: function (error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                })


                // Cierra la ventana modal
                jQuery('.modal').modal('hide');
            });
        });

    </script>

    <style>
        .div {
            font-family: Arial, sans-serif;
            margin-top: 15%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-canjear {
            margin-left: 3%;
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }
    </style>

    <div class="div">
        <form method="POST">
            <h2>Canjear Cupones</h2>
            <h2>Buscar Usuario:</h2>
            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" placeholder="Ingrese su DNI" required>
            <button class="buscar-btn" type="button">Buscar</button>
        </form>
    </div>

    <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title" id="nombre"></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <form id="miFormulario">
                    <!-- Contenido del Modal -->
                    <div class="modal-body">




                    </div>

                    <button type="submit" class="btn btn-primary btn-canjear">Canjear</button>

                </form>
                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                </div>


            </div>
        </div>
    </div>

    <?php
}
add_shortcode('canjeo_cupones', 'canjeo_cupones_shortcode');

function mostrar_cupones_canjeados_por_comercio_shortcode()
{
    $actual_id = get_current_user_id();

    $cupones_canjeados = getCuponesComercioId($actual_id);
    $contador = 1;

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        #tabla {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        #tabla th,
        #tabla td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        #tabla th {
            background-color: #f2f2f2;
            color: #333;
        }

        #tabla tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #tabla tbody tr:hover {
            background-color: #ddd;
        }

        .container {
            margin-top: 50px;
        }
    </style>

    <div class="container">
        <h2>Cupones Canjeados</h2>
        <table class="table" id="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titulo del Cupon</th>
                    <th>Descripcion</th>
                    <th>DNI Usuario</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Fecha Canjeo</th>
                    <th>Canjeado</th>
                </tr>
            </thead>
            <tbody>
                <!-- Filas de prueba -->
                <?php
                foreach ($cupones_canjeados as $cupon) {

                    // Fecha actual
                    $fecha_actual = new DateTime();

                    // Convertir la fecha proporcionada a objeto DateTime
                    $fecha_proporcionada_objeto = DateTime::createFromFormat('Y-m-d', $cupon['fecha_fin']);

                    // Comparar las fechas
                    if ($fecha_proporcionada_objeto < $fecha_actual && $cupon['canjeado'] == 0) {
                        $canjeado = "Expirado";
                    } else {
                        $canjeado = ($cupon['canjeado'] == 0) ? 'No Canjeado' : 'Canjeado';
                    }

                    $id_usuario = $cupon['user_id'];
                    $user_data = get_userdata($id_usuario);

                    $titulo = $cupon['titulo'];
                    $descripcion = $cupon['descripcion'];
                    $dni_usuario = $user_data->user_login;
                    $fecha_canjeo = $cupon['fecha_canjeo'];
                    $fecha_inicio = $cupon['fecha_inicio'];
                    $fecha_fin = $cupon['fecha_fin'];
                    ?>
                    <tr>
                        <td>
                            <?php echo $contador; ?>
                        </td>
                        <td>
                            <?php echo $titulo; ?>
                        </td>
                        <td>
                            <?php echo $descripcion; ?>
                        </td>
                        <td>
                            <?php echo $dni_usuario; ?>
                        </td>
                        <td>
                            <?php echo $fecha_inicio; ?>
                        </td>
                        <td>
                            <?php echo $fecha_fin; ?>
                        </td>
                        <td>
                            <?php echo ($fecha_canjeo != "0000-00-00") ? $fecha_canjeo : " "; ?>
                        </td>
                        <td>
                            <?php echo $canjeado; ?>
                        </td>
                    </tr>
                    <?php
                    $contador++;
                }
                ?>
            </tbody>
        </table>
    </div>


    <?php
}
add_shortcode('mostrar_cupones_canjeados_por_comercio', 'mostrar_cupones_canjeados_por_comercio_shortcode');

function cupones_total_shortcode()
{

    if (is_user_logged_in()) {
        $cupones = getCupones();
        $user_id = get_current_user_id();
        $contador = 0;

        ?>
        <style>
            body.overlay-active {
                overflow: hidden;
                /* Evita el desplazamiento del cuerpo mientras el banner está abierto */
            }

            /* Estilo general del contenedor */
            .premios-container {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                margin: 20px 0;
            }

            /* Estilo de cada premio */
            .premio {
                width: 300px;
                margin: 20px;
                padding: 15px;
                border: 1px solid #ccc;
                text-align: center;
                background-color: #f9f9f9;
                /* Fondo gris claro */
                border-radius: 10px;
                /* Bordes redondeados */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                /* Sombra suave */
            }

            /* Estilo para el nombre del premio */
            .nombre-premio {
                display: inline-block;
                font-size: 24px;
                /* Tamaño de la fuente */
                color: #333;
                /* Color del texto */
                margin-bottom: 10px;
                /* Espaciado inferior */
                /* Otros estilos que desees agregar */
            }

            /* Estilo para la información adicional */
            .premio p {
                margin: 8px 0;
                color: #666;
                /* Color del texto secundario */
            }

            /* Estilo para el texto "Este premio ya lo has canjeado" */
            .premio p strong.red {
                color: red;
            }

            /* Estilo para el texto "Puedes canjear este premio" */
            .premio p strong.green {
                color: green;
            }

            /* Estilo para el botón de canjeo */
            .canjear-btn {
                background-color: #4CAF50;
                /* Color de fondo verde */
                color: white;
                /* Color del texto */
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s ease;
                /* Transición suave */
            }

            .canjear-btn:hover {
                background-color: #45a049;
                /* Color de fondo verde oscuro al pasar el ratón */
            }

            /* Estilo para el enlace "Más información" */
            .más-info {
                color: #007bff;
                /* Color del texto azul */
                text-decoration: none;
                transition: color 0.3s ease;
                /* Transición suave */
            }

            .más-info:hover {
                color: #0056b3;
                /* Color del texto azul oscuro al pasar el ratón */
            }

            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                /* Fondo oscuro semi-transparente */
                display: none;
                /* Por defecto oculto */
                justify-content: center;
                align-items: center;
            }

            .banner {
                display: none;
                /* Por defecto oculto */
                position: relative;
                width: 90%;
                /* Utilizando un porcentaje del ancho de la pantalla */
                height: 90vh;
                /* Utilizando un porcentaje del alto de la pantalla */
                max-width: 90vh;
                /* Limitando el ancho máximo */
                max-height: 90vh;
                /* Limitando la altura máxima */
                padding: 10px;
                border-radius: 10px;
                /* Bordes redondeados */
                margin-top: 10%;
            }

            .close {
                position: absolute;
                top: 5px;
                right: 5px;
                color: white;
                /* Color del icono de la x */
                background-color: black;
                /* Color de fondo del icono de la x */
                border: none;
                cursor: pointer;
                border-radius: 50%;
                /* Hace que el botón tenga forma de círculo */
                padding: 5px;
                /* Aumenta el espacio alrededor del icono */
                z-index: 1;
                /* Asegura que el botón esté por encima del contenido */
            }

            .icono {
                width: 50px;
                /* Establece el ancho del icono */
                height: auto;
                /* Mantiene la proporción de aspecto */
                margin-left: 10px;
                /* Espacio entre el icono y el título */
                display: inline-block;
            }

            @media (max-width: 768px) {
                #bannerImage {
                    max-width: 100%;
                    /* La imagen ocupará el 100% del ancho disponible */
                    height: auto;
                    /* La altura se ajustará automáticamente según el ancho */
                    display: block;
                    /* Asegura que la imagen no tenga espacios en blanco debajo */
                    margin-left: 20px;
                }


            }
        </style>

        <h2>
            Cupones Disponibles
        </h2>

        <div class="premios-container">
            <?php foreach ($cupones as $cupon): ?>
                <?php
                    $fecha_actual = new DateTime();
                    $fecha_fin_cupon = new DateTime($cupon['fecha_fin']);
                    $resultado = ($fecha_actual > $fecha_fin_cupon || $fecha_actual == $fecha_fin_cupon) ? false : true;

                    if($cupon['user_id'] == $user_id && $cupon['canjeado'] == 0 && $resultado == true){
                        ?>
                            <div class="premio">
                                <h2 class="nombre-premio">
                                    <?php echo $cupon['titulo']; ?>
                                </h2>
                                <p><strong>Descripcion:</strong>
                                    <?php echo $cupon['descripcion']; ?>
                                </p>
                                <p><strong>Fecha maxima de canjeo:</strong>
                                    <?php echo $cupon['fecha_fin']; ?>
                                </p>
                            </div>
                        <?php
                        $contador++;
                    }    
                ?>
            <?php endforeach; ?>
        </div>
        <?php

        if($contador == 0){
            ?>
                <div class="premios-container">
                    <h2>
                        Aún no tienes cupones disponibles
                    </h2>
                    
                </div>
            <?php
        }
    }
}
add_shortcode('cupones_shortcode', 'cupones_total_shortcode');