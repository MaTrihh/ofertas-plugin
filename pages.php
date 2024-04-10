<?php
function agregar_menu_admin() {
    add_menu_page(
        'Alcala Centro',                        // Título de la página principal
        'Alcala Centro',                        // Texto del menú principal
        'manage_options',                       // Capacidad requerida para acceder
        'alcala_centro_menu',                   // ID único del menú principal
        'validacion_usuarios_tarjeta_puntos_page', // Función que muestra la página principal
        'dashicons-admin-site',                 // Icono del menú principal
        5                                       // Posición en el menú
    );

    add_submenu_page(
        'alcala_centro_menu',                   // ID del menú principal
        'Validar Usuarios',                     // Título de la página del submenú
        'Validar Usuarios',                     // Texto del submenú
        'manage_options',                       // Capacidad requerida para acceder
        'validar_usuarios',                     // ID único de la página del submenú
        'validacion_usuarios_tarjeta_puntos_page' // Función que muestra la página del submenú
    );

    add_submenu_page(
        'alcala_centro_menu',                   // ID del menú principal
        'Validar Comercios',                    // Título de la página del submenú
        'Validar Comercios',                    // Texto del submenú
        'manage_options',                       // Capacidad requerida para acceder
        'validar_comercios',                    // ID único de la página del submenú
        'validacion_comercios_page'             // Función que muestra la página del submenú
    );

    add_submenu_page(
        'alcala_centro_menu',                   // ID del menú principal
        'Administración de campañas',                    // Título de la página del submenú
        'Administración de campañas',                    // Texto del submenú
        'manage_options',                       // Capacidad requerida para acceder
        'administracion_de_campanas',                    // ID único de la página del submenú
        'administracion_de_campanas_page'             // Función que muestra la página del submenú
    );

    add_submenu_page(
        'alcala_centro_menu',                   // ID del menú principal
        'Administración de Comercios Asociados',                    // Título de la página del submenú
        'Administración de Comercios Asociados',                    // Texto del submenú
        'manage_options',                       // Capacidad requerida para acceder
        'administracion_de_asociados',                    // ID único de la página del submenú
        'administracion_de_asociados_page'             // Función que muestra la página del submenú
    );

    add_submenu_page(
        'alcala_centro_menu',                   // ID del menú principal
        'Excel',                    // Título de la página del submenú
        'Excel',                    // Texto del submenú
        'manage_options',                       // Capacidad requerida para acceder
        'excel',                    // ID único de la página del submenú
        'excel_page'             // Función que muestra la página del submenú
    );

    add_submenu_page(
        'alcala_centro_menu',                   // ID del menú principal
        'Correos',                    // Título de la página del submenú
        'Correos',                    // Texto del submenú
        'manage_options',                       // Capacidad requerida para acceder
        'correos',                    // ID único de la página del submenú
        'correos_page'             // Función que muestra la página del submenú
    );
}
add_action('admin_menu', 'agregar_menu_admin');


function correos_page() {
    ?>

    <!-- Incluye las bibliotecas de Bootstrap y jQuery -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        jQuery(document).ready(function() {
            // Al hacer clic en el botón "Crear Premio"
            jQuery(".editar-btn").on("click", function() {
                // Mostrar el modal
                jQuery("modal").modal("show");
            });

            // Al cerrar el modal
            jQuery("#miModal").on("hidden.bs.modal", function () {
                // Limpiar el formulario al cerrar el modal
                jQuery("#miFormulario")[0].reset();
            });

            // Al enviar el formulario dentro del modal
            jQuery("#miFormulario").on("submit", function(event) {
                // Evitar que el formulario se envíe normalmente
                event.preventDefault();

                // Obtener valores del formulario
                var nombre = jQuery("#nombre").val();
                var descuento = jQuery("#descuento").val();
                var coste = jQuery("#coste").val();

                // Realizar la solicitud AJAX
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "crear_premio", // Acción que indica qué función de PHP llamar
                        nombre: nombre,
                        descuento: descuento,
                        coste: coste
                    },
                    success: function(response) {
                        // Hacer algo con la respuesta del servidor (si es necesario)
                        console.log(response);
                    },
                    error: function(error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });
                

                // Cerrar el modal
                jQuery("#miModal").modal("hide");

                location.reload();
            });
        });


        /*
        jQuery(document).ready(function ($) {
            $('.editar-btn, .borrar-mensaje-btn').on('click', function (e) {
                e.preventDefault();

                var button = $(this);
                var userId = button.data('user-id');
                var action = button.data('action');

                // Realiza tu llamada AJAX utilizando el sistema AJAX de WordPress
                $.ajax({
                    url: ajaxurl, // admin-ajax.php proporcionado por WordPress
                    type: 'POST',
                    data: {
                        action: action,
                        user_id: userId,
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });
        */
    </script>

    <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Editar Mensaje</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <!-- Contenido del Modal -->
                <div class="modal-body">
                    <form id="miFormulario">
                        <!-- Contenido de tu formulario -->
                        <div class="form-group">
                            <label for="mensaje">Mensaje:</label>
                            <input type="text" class="form-control" id="mensaje" name="mensaje" required>
                        </div>
                        <!-- Agrega más campos según sea necesario -->

                        <button type="submit" class="btn btn-primary">Editar</button>
                    </form>
                </div>

                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                </div>

            </div>
        </div>
    </div>

    <div class="wrap">
        <h1>Correos</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Mensaje</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $correos = getCorreos(); 

                foreach ($correos as $correo) {

                    $id = $correo['id'];
                    $nombre = $correo['nombre'];
                    $mensaje = $correo['mensaje'];
                    

                    ?>
                    <tr>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $mensaje; ?></td>
                        <td>
                        <a href="#" class="button button-primary editar-btn" data-user-id="<?php echo $id; ?>" data-id="<?php echo $id; ?>" data-toggle="modal" data-target="#miModal">Editar</a>
                        <a href="#" class="button button-secondary borrar-mensaje-btn" data-user-id="<?php echo $id; ?>" data-action="borrar_mensaje">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php    
}

function editar_mensaje_callback() {

}
add_action('wp_ajax_editar_mensaje', 'editar_mensaje_callback');

function validacion_usuarios_tarjeta_puntos_page() {
    // Código para la página de administración
    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        jQuery(document).ready(function ($) {

            //**************Rechazar usuario*****************
            jQuery(".borrar-usu-btn").on("click", function() {
            // Mostrar el modal
                jQuery("#miModal").modal("show");
            });

            // Al cerrar el modal
            jQuery("#miModal").on("hidden.bs.modal", function () {
                // Limpiar el formulario al cerrar el modal
                jQuery("#rechazar-usuarios")[0].reset();
            });


            //**************Verificar usuario*****************
            $('.verificar-btn').on('click', function (e) {
                e.preventDefault();

                var button = $(this);
                var userId = button.data('user-id');
                var action = button.data('action');

                // Realiza tu llamada AJAX utilizando el sistema AJAX de WordPress
                $.ajax({
                    url: ajaxurl, // admin-ajax.php proporcionado por WordPress
                    type: 'POST',
                    data: {
                        action: action,
                        user_id: userId,
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });

            // Al enviar el formulario dentro del modal
            jQuery("#enviarFormularioBtn").on("click", function(e) {
                // Evitar que el formulario se envíe normalmente
                e.preventDefault();

                // Obtener valores del formulario
                var mensaje = jQuery("#mensaje").val();
                var asunto = jQuery("#asunto").val();
                var userid = jQuery(".borrar-usu-btn").data('user-id');

                // Realizar la solicitud AJAX
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    data: {
                        action: "correo_user_rechazado", // Acción que indica qué función de PHP llamar
                        mensaje: mensaje,
                        asunto: asunto,
                        userid: userid
                    },
                    success: function(response) {
                        // Hacer algo con la respuesta del servidor (si es necesario)
                        var responseData = JSON.parse(response);
                        console.log(responseData.message); // Debería imprimir 'Correo enviado correctamente.'
                        jQuery("#miModal").modal("hide");

                        // Cerrar el modal
                        jQuery("#miModal").modal("hide");
                        location.reload();
                    },
                    error: function(error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });
            });
        });
    </script>

    <!-- Ventana modal -->
    <div class="modal" id="miModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Encabezado del Modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Rechazar usuario</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>
                </div>

                <!-- Contenido del Modal -->
                <div class="modal-body">
                    <form id="rechazar-usuarios" method="post">
                        <!-- Contenido de tu formulario -->
                        <div class="form-group">
                            <label for="asunto">Asunto del correo:</label>
                            <input type="text" class="form-control" id="asunto" name="asunto" required>

                            </br>

                            <label for="mensaje">Mensaje:</label>
                            <input type="text" class="form-control" id="mensaje" name="mensaje" required>

                        </div>
                        <button type="submit" class="btn btn-primary" id="enviarFormularioBtn">Enviar</button>
                     </form>
                </div>

                <!-- Pie del Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarModalBtn">Cerrar</button>
                </div>

            </div>
        </div>
    </div>


    <div class="wrap">
        <h1>Usuarios Tarjeta Sin Verificar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Numero de tarjeta</th>
                    <th>Dni</th>
                    <th>Telefono</th>
                    <th>Localidad</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $usuarios_sin_verificar = get_users(array('role' => 'usuario_tarjeta_sin_verificar'));

                foreach ($usuarios_sin_verificar as $usuario) {

                    //$numTarjeta = get_user_meta($usuario->ID, 'numero_tarjeta', true);
                    $telefono = get_user_meta($usuario->ID, 'telefono', true);
                    $localidad = get_user_meta($usuario->ID, 'localidad', true);
                    $dni = get_user_meta($usuario->ID, 'dni', true);
                    $direccion = get_user_meta($usuario->ID, 'direccion', true);
                    $numTarjeta = get_user_meta($usuario->ID, 'numero_tarjeta', true);
                    

                    ?>
                    <tr>
                        <td><?php echo esc_html($usuario->display_name); ?></td>
                        <td><?php echo esc_html($usuario->user_email); ?></td>
                        <td><?php echo $numTarjeta; ?></td>
                        <td><?php echo $dni; ?></td>
                        <td><?php echo $telefono; ?></td>
                        <td><?php echo $localidad; ?></td>
                        <td><?php echo $direccion; ?></td>
                        <td>
                        <a class="button button-primary verificar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="verificar_usuario">Verificar</a>
                        <a class="button button-secondary borrar-usu-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="borrar_usuario_antiguo">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="wrap">
        <h1>Usuarios Antiguos Tarjeta Sin Verificar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Numero de tarjeta</th>
                    <th>Dni</th>
                    <th>Telefono</th>
                    <th>Localidad</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $usuarios_sin_verificar = get_users(array('role' => 'usuario_antiguo_tarjeta_sin_verificar'));

                foreach ($usuarios_sin_verificar as $usuario) {

                    $numTarjeta = get_user_meta($usuario->ID, 'numero_tarjeta', true);
                    $telefono = get_user_meta($usuario->ID, 'telefono', true);
                    $localidad = get_user_meta($usuario->ID, 'localidad', true);
                    $dni = get_user_meta($usuario->ID, 'dni', true);

                    $direccion = get_user_meta($usuario->ID, 'direccion', true);
                    $nombre = $usuario->first_name . ' ' . $usuario->last_name;

                    ?>
                    <tr>
                        <td><?php echo esc_html($usuario->display_name); ?></td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo esc_html($usuario->user_email); ?></td>
                        <td><?php echo $numTarjeta; ?></td>
                        <td><?php echo $dni; ?></td>
                        <td><?php echo $telefono; ?></td>
                        <td><?php echo $localidad; ?></td>
                        <td><?php echo $direccion; ?></td>
                        <td>
                        <a class="button button-primary verificar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="verificar_usuario_antiguo">Verificar</a>
                        <a class="button button-secondary borrar-usu-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="borrar_usuario_antiguo">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="wrap">
        <h1>Usuarios DeAlcala Sin Verificar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Localidad</th>
                    <th>Direccion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $usuarios_sin_verificar = get_users(array('role' => 'usuario_dealcala_sin_verificar'));

                foreach ($usuarios_sin_verificar as $usuario) {

                    $direccion = get_user_meta($usuario->ID, 'direccion', true);
                    $telefono = get_user_meta($usuario->ID, 'telefono', true);
                    $localidad = get_user_meta($usuario->ID, 'localidad', true);
                    $nombre = $usuario->first_name . ' ' . $usuario->last_name;

                    ?>
                    <tr>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo esc_html($usuario->user_email); ?></td>
                        <td><?php echo $telefono; ?></td>
                        <td><?php echo $localidad; ?></td>
                        <td><?php echo $direccion; ?></td>
                        <td>
                        <a class="button button-primary verificar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="verificar_usuario_dealcala">Verificar</a>
                        <a class="button button-secondary borrar-usu-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="borrar_usuario_dealcala">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

function verificar_usuario_antiguo_callback() {

    $user_id = $_POST['user_id'];
    $telefono = get_user_meta($user_id, 'telefono', true);
    $dni = get_user_meta($user_id, 'dni', true);
    
    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos terminada';
        $message = 'Gracias por actualizar tus datos, se han verificado tus datos correctamente y a partir de este momento ya puedes acceder a la zona privada de usuario con tu DNI '.$dni.' y clave '. $telefono .' . Muchas gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <info@comercio10.es>',
        );  

        wp_mail($to, $subject, $message, $headers);

        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'usuario_antiguo_tarjeta_sin_verificar' );

        // Add role
        $u->add_role( 'usuario_tarjeta' );

        $servername = "rdbms.strato.de";
        $username = "dbu2152616";
        $password = "alcala23680";
        $database = "dbs12375000";
    
        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);
    
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        // Consulta para obtener todas las tuplas
        $sql = "INSERT INTO usuarios (id_usuario, puntos) VALUES ('$user_id', 50)";
        $conn->query($sql);


    }

    wp_die();
}
add_action('wp_ajax_verificar_usuario_antiguo', 'verificar_usuario_antiguo_callback');

function verificar_usuario_callback() {

    $user_id = $_POST['user_id'];
    $telefono = get_user_meta($user_id, 'telefono', true);
    $dni = get_user_meta($user_id, 'dni', true);
    
    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos terminada';
        $message = 'Gracias por registrarte, se han verificado tus datos correctamente y a partir de este momento ya puedes acceder a la zona privada de usuario con tu DNI '. $dni .' y clave '. $telefono .' . Muchas gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <info@comercio10.es>',
        );  

        wp_mail($to, $subject, $message, $headers);

        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'usuario_tarjeta_sin_verificar' );

        // Add role
        $u->add_role( 'usuario_tarjeta' );

        $servername = "rdbms.strato.de";
        $username = "dbu2152616";
        $password = "alcala23680";
        $database = "dbs12375000";
    
        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);
    
        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        // Consulta para obtener todas las tuplas
        $sql = "INSERT INTO usuarios (id_usuario, puntos) VALUES ('$user_id', 50)";
        $conn->query($sql);

    }

    wp_die();
}
add_action('wp_ajax_verificar_usuario', 'verificar_usuario_callback');

function verificar_usuario_dealcala_callback() {

    $user_id = $_POST['user_id'];
    $telefono = get_user_meta($user_id, 'telefono', true);
    
    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos terminada';
        $message = 'Gracias por registrarte, se han verificado tus datos correctamente y a partir de este momento ya puedes acceder a las promociones con tu correo y clave '. $telefono .' . Muchas gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <info@comercio10.es>',
        );  

        wp_mail($to, $subject, $message, $headers);

        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'usuario_dealcala_sin_verificar' );

        // Add role
        $u->add_role( 'usuario_dealcala' );

    }

    wp_die();
}
add_action('wp_ajax_verificar_usuario_dealcala', 'verificar_usuario_dealcala_callback');

function borrar_usuario_callback() {

    $user_id = $_POST['user_id'];

    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos fallida';
        $message = 'Hola, hemos recibido los datos mal o con algun error. Contacta con nosotros para solucionarlo. Gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);
    }

    if (username_exists($user_id)) {
        $result = wp_delete_user($user_id, true);
    
        if (is_wp_error($result)) {
            echo 'Error al intentar eliminar el usuario: ' . $result->get_error_message();
        } else {
            echo 'Usuario eliminado con éxito.';
        }
    } else {
        echo 'El usuario no existe.';
    }

    wp_die();
}
add_action('wp_ajax_borrar_usuario', 'borrar_usuario_callback');

function borrar_usuario_antiguo_callback() {

    $user_id = $_POST['user_id'];

    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos fallida';
        $message = 'Hola, hemos recibido los datos mal o con algun error. Contacta con nosotros para solucionarlo. Gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);
    }

    if (username_exists($user_id)) {
        $result = wp_delete_user($user_id, true);
    
        if (is_wp_error($result)) {
            echo 'Error al intentar eliminar el usuario: ' . $result->get_error_message();
        } else {
            echo 'Usuario eliminado con éxito.';
        }
    } else {
        echo 'El usuario no existe.';
    }

    wp_die();
}
add_action('wp_ajax_borrar_usuario_antiguo', 'borrar_usuario_antiguo_callback');

function validacion_comercios_page() {
    // Código para la página de administración
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $('.verificar-btn, .borrar-btn').on('click', function (e) {
                e.preventDefault();

                var button = $(this);
                var userId = button.data('user-id');
                var action = button.data('action');

                // Realiza tu llamada AJAX utilizando el sistema AJAX de WordPress
                $.ajax({
                    url: ajaxurl, // admin-ajax.php proporcionado por WordPress
                    type: 'POST',
                    data: {
                        action: action,
                        user_id: userId,
                    },
                    success: function (response) {
                        location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>


    <div class="wrap">
        <h1>Comercio Asociado Sin Verificar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Cif</th>
                    <th>Nombre Fiscal</th>
                    <th>Nombre Comercial</th>
                    <th>Direccion Fiscal</th>
                    <th>Direccion Comercial</th>
                    <th>Telefono Comercial</th>
                    <th>Correo Comercial</th>
                    <th>Logotipo</th>
                    <th>Fachada</th>
                    <th>Interior</th>
                    <th>PDF Alta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $usuarios_sin_verificar = get_users(array('role' => 'comercio_asociado_sin_verificar'));

                foreach ($usuarios_sin_verificar as $usuario) {
                    ?>
                    <tr>
                        <td><?php echo esc_html($usuario->display_name); ?></td>
                        <td><?php echo esc_html($usuario->user_email); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'cif', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'nombre_fiscal', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'nombre_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'direccion_fiscal', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'direccion_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'telefono_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'correo_comercial', true); ?></td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'logotipo', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'fachada', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'interior', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'alta', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                        <a href="#" class="button button-primary verificar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="verificar_comercio_asociado">Verificar</a>
                        <a href="#" class="button button-secondary borrar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="borrar_comercio_asociado">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="wrap">
        <h1>Comercio Amigo Sin Verificar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Cif</th>
                    <th>Nombre Fiscal</th>
                    <th>Nombre Comercial</th>
                    <th>Direccion Fiscal</th>
                    <th>Direccion Comercial</th>
                    <th>Telefono Comercial</th>
                    <th>Correo Comercial</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $usuarios_sin_verificar = get_users(array('role' => 'comercio_no_asociado_sin_verificar'));

                foreach ($usuarios_sin_verificar as $usuario) {
                    ?>
                    <tr>
                        <td><?php echo esc_html($usuario->display_name); ?></td>
                        <td><?php echo esc_html($usuario->user_email); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'cif', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'nombre_fiscal', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'nombre_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'direccion_fiscal', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'direccion_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'telefono_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'correo_comercial', true); ?></td>
                        <td>
                        <a href="#" class="button button-primary verificar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="verificar_comercio_no_asociado">Verificar</a>
                        <a href="#" class="button button-secondary borrar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="borrar_comercio_no_asociado">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="wrap">
        <h1>Comercio Asociado Antiguo Sin Verificar</h1>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Numero Asociado</th>
                    <th>Email</th>
                    <th>Cif</th>
                    <th>Nombre Fiscal</th>
                    <th>Nombre Comercial</th>
                    <th>Direccion Fiscal</th>
                    <th>Direccion Comercial</th>
                    <th>Telefono Comercial</th>
                    <th>Correo Comercial</th>
                    <th>Logotipo</th>
                    <th>Fachada</th>
                    <th>Interior</th>
                    <th>PDF Alta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $usuarios_sin_verificar = get_users(array('role' => 'comercio_antiguo'));

                foreach ($usuarios_sin_verificar as $usuario) {
                    ?>
                    <tr>
                        <td><?php echo esc_html($usuario->display_name); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'numero_asociado', true); ?></td>
                        <td><?php echo esc_html($usuario->user_email); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'cif', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'nombre_fiscal', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'nombre_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'direccion_fiscal', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'direccion_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'telefono_comercial', true); ?></td>
                        <td><?php echo get_user_meta($usuario->ID, 'correo_comercial', true); ?></td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'logotipo', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'fachada', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'interior', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="<?php echo get_user_meta($usuario->ID, 'alta', true); ?>" target="_blank">Ver</a>
                        </td>
                        <td>
                            <a href="#" class="button button-primary verificar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="verificar_comercio_antiguo">Verificar</a>
                            <a href="#" class="button button-secondary borrar-btn" data-user-id="<?php echo esc_attr($usuario->ID); ?>" data-action="borrar_comercio_antiguo">Borrar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

function verificar_comercio_asociado_callback() {

    $user_id = $_POST['user_id'];
    $telefono = get_user_meta($user_id, 'telefono_personal', true);
    
    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos terminada';
        $message = 'Gracias por registrarte, se han verificado tus datos correctamente y  a partir de este momento ya puedes acceder a la zona privada de socio con tu correo '. $email.' y clave '.$telefono.' . Muchas gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);

        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'comercio_asociado_sin_verificar' );

        // Add role
        $u->add_role( 'comercio_asociado' );

    }

    wp_die();
}
add_action('wp_ajax_verificar_comercio_asociado', 'verificar_comercio_asociado_callback');

function denegar_comercio_asociado_callback() {

    $user_id = $_POST['user_id'];

    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos fallida';
        $message = 'Hola, hemos recibido los datos mal o con algun error. Contacta con nosotros para solucionarlo. Gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);
    }

    /*
    if (username_exists($user_id)) {
        $result = wp_delete_user($user_id, true);
    
        if (is_wp_error($result)) {
            echo 'Error al intentar eliminar el usuario: ' . $result->get_error_message();
        } else {
            echo 'Usuario eliminado con éxito.';
        }
    } else {
        echo 'El usuario no existe.';
    }^
    */

    wp_die();
}
add_action('wp_ajax_borrar_comercio_asociado', 'denegar_comercio_asociado_callback');

function verificar_comercio_no_asociado_callback() {

    $user_id = $_POST['user_id'];
    $telefono = get_user_meta($user_id, 'telefono_personal', true);
    
    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos terminada';
        $message = 'Gracias por registrarte, se han verificado tus datos correctamente y a partir de este momento ya puedes acceder a la zona privada de socio con tu correo '. $email.' y clave '.$telefono.' . En breve nos comunicamos contigo para darte instrucciones sobre el alta de registro. Muchas gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);

        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'comercio_no_asociado_sin_verificar' );

        // Add role
        $u->add_role( 'comercio_no_asociado' );

    }

    wp_die();
}
add_action('wp_ajax_verificar_comercio_no_asociado', 'verificar_comercio_no_asociado_callback');

function denegar_comercio_no_asociado_callback() {

    $user_id = $_POST['user_id'];

    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos fallida';
        $message = 'Hola, hemos recibido los datos mal o con algun error. Contacta con nosotros para solucionarlo. Gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);
    }

    
    if (get_user_by('ID', $user_id)) {
        $result = wp_delete_user($user_id, true);
    
        if (is_wp_error($result)) {
            echo 'Error al intentar eliminar el usuario: ' . $result->get_error_message();
        } else {
            echo 'Usuario eliminado con éxito.';
        }
    } else {
        echo 'El usuario no existe.';
    }
    

    wp_die();
}
add_action('wp_ajax_borrar_comercio_no_asociado', 'denegar_comercio_no_asociado_callback');

function verificar_comercio_antiguo_callback() {

    $user_id = $_POST['user_id'];
    $telefono = get_user_meta($user_id, 'telefono_personal', true);
    
    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos terminada';
        $message = 'Gracias por actualizar tus datos, se han verificado tus datos correctamente y a partir de este momento ya puedes acceder a la zona privada de socio con tu correo '.$email.' y clave '.$telefono.' . Muchas gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        ); 

        wp_mail($to, $subject, $message, $headers);

        $u = new WP_User( $user_id );

        // Remove role
        $u->remove_role( 'comercio_antiguo' );

        // Add role
        $u->add_role( 'comercio_asociado' );

    }

    wp_die();
}
add_action('wp_ajax_verificar_comercio_antiguo', 'verificar_comercio_antiguo_callback');

function denegar_comercio_antiguo_callback() {

    $user_id = $_POST['user_id'];

    $user_info = get_userdata($user_id);

    if ($user_info) {
        $email = $user_info->user_email;

        $to = $email;
        $subject = 'Verificacion de datos fallida';
        $message = 'Hola, hemos recibido los datos mal o con algun error. Contacta con nosotros para solucionarlo. Gracias';

        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Alcala Centro <incidencias@alcalacentro.com>',
        );  

        wp_mail($to, $subject, $message, $headers);
    }

    /*
    if (username_exists($user_id)) {
        $result = wp_delete_user($user_id, true);
    
        if (is_wp_error($result)) {
            echo 'Error al intentar eliminar el usuario: ' . $result->get_error_message();
        } else {
            echo 'Usuario eliminado con éxito.';
        }
    } else {
        echo 'El usuario no existe.';
    }^
    */

    wp_die();
}
add_action('wp_ajax_borrar_comercio_no_asociado', 'denegar_comercio_asociado_no_callback');

function administracion_de_campanas_page() {

    ?>
        <style>
            /* Estilos para la tabla y el div */
            #tablaCampanas {
                width: 70%;
                margin: 20px auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            th, td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            th:nth-child(1) {
                width: 30%;
            }

            #selectorCampanas {
                display: block;
                margin-bottom: 10px;
                width: 100%;
                padding: 8px;
                font-size: 16px;
                border: 1px solid #ddd;
                border-radius: 5px;
                box-sizing: border-box;
            }
        </style>

        <script>
            jQuery(document).ready(function() {
            // Detecta el cambio en el select y ejecuta la función
            jQuery('#selectorCampanas').change(function() {
                // Obtén el valor seleccionado
                var selectedValue = jQuery(this).val();

                // Ejecuta la función con el valor seleccionado
                handleSelectChange(selectedValue);
            });

            var urlParams = new URLSearchParams(window.location.search);
            var selectedValue = urlParams.get('campana');

            // Función que se ejecutará al cambiar el valor del select
            function handleSelectChange(selectedValue) {
                // Puedes agregar aquí tu lógica para manejar el cambio en el select
                window.location.href = window.location.href + '&campana=' + selectedValue;
            }
            });
        </script>

        <label for="selectorCampanas">Selecciona la Campaña:</label>
        <select id="selectorCampanas">
            <!-- Aquí puedes agregar opciones según tus necesidades -->
            <option value="vacio"></option>
            <option value="todos">Todas las Campañas</option>
            <option value="pago_anual">Pago Cuota Anual</option>
            <option value="cuota_comercio10">Cuota Comercio10</option>
            <option value="campana_san_valentin">Campaña San Valentin</option>
            <option value="campana_dia_del_padre">Campaña Dia del Padre</option>
            <option value="campana_primavera">Campaña Primavera</option>
            <option value="campana_especial">Campaña Especial</option>
            <option value="campana_dia_de_la_madre">Dia de la madre</option>
            <option value="campana_verano">Campaña Verano</option>
            <option value="campana_vuelta_al_cole">Campaña Vuelta al cole</option>
            <option value="campana_halloween">Campaña Halloween</option>
            <option value="campana_black_friday">Campaña Black Friday</option>
            <option value="campana_navidad">Campaña Navidad</option>
        </select>

        <!-- Div con la tabla de campañas -->
        <div id="tablaCampanas">
            <table>
            <thead>
                <tr>
                    <th>Nombre Campaña</th>
                    <th>Nombre Comercio</th>
                </tr>
            </thead>
            <tbody>
    <?php  

    $selectedValue = isset($_GET['campana']) ? $_GET['campana'] : '';
    
    if(isset($selectedValue)){
        if($selectedValue == "todos"){

            $campanas = obtenerTodosComerciosPorCampana();
            

            foreach($campanas as $campana => $comercio){

                asort($comercio);

                ?>
                        <tr>
                            <td><?php echo $campana; ?></td>
                            <td>
                                <?php
                                    foreach ($comercio as $comercio_nombre) {

                                        echo "<li>". $comercio_nombre ."</li>";
                                    }
                                ?>
                            </td>
                        </tr>
                <?php
            }
            ?>
                    </tbody>
                    </table>
                </div>
            <?php

        }else{
            $campanas = obtenerComerciosPorCampana($selectedValue);
            
            ?>
                <tr>
                    <td><?php echo $selectedValue; ?></td>
                    <td>
                    <?php
                        asort($campanas);
                        foreach($campanas as $comercio){

                            ?>
                            
                                <?php
                                    echo "<li>" . $comercio . "</li>";   
                                ?>
                            
                            <?php
                        }
                    ?>
                    </td>
                </tr>
            <?php        
        }
    }

}

function administracion_de_asociados_page() {

    ?>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 20px auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: auto; /* Añadido para hacer la tabla scrollable */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
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

        .url-column {
            max-width: 300px; /* Puedes ajustar este valor según tus necesidades */
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Numero Asociado</th>
                    <th>Nombre Comercial</th>
                    <th>Correo Electrónico</th>
                    <th>Telefono Comercial</th>
                    <th>Telefono Personal</th>
                    <th>CIF-NIF</th>
                    <th>Nombre fiscal</th>
                    <th>Direccion Fiscal</th>
                    <th>Direccion Comercial</th>
                    <th>Logotipo</th>
                    <th>Fachada</th>
                    <th>Interior</th>
                    <th>URL Web</th>
                    <th>URL Instagram</th>
                    <th>URL Twitter</th>
                    <th>URL Facebook</th>
                    <th>URL Tiktok</th>
                    <th>Sectores</th>
                    <th>Campañas</th>
                </tr>
            </thead>
            <tbody>

            <?php
                $usuarios_comercio_asociado = get_users( array(
                    'role'    => 'comercio_asociado',
                    'orderby' => 'user_nicename',
                    'order'   => 'ASC'
                ) );

                foreach($usuarios_comercio_asociado as $comercio){
                
                    $nombre_comercial = get_user_meta($comercio->ID, 'nombre_comercial', true);
                    $telefono_comercial = get_user_meta($comercio->ID, 'telefono_comercial', true);
                    $telefono_personal = get_user_meta($comercio->ID, 'telefono_personal', true);
                    $cif = get_user_meta($comercio->ID, 'cif', true);
                    $nombre_fiscal = get_user_meta($comercio->ID, 'nombre_fiscal', true);
                    $direccion_fiscal = get_user_meta($comercio->ID, 'direccion_fiscal', true);
                    $direccion_comercial = get_user_meta($comercio->ID, 'direccion_comercial', true);
                    $logotipo = get_user_meta($comercio->ID, 'logotipo', true);
                    $fachada = get_user_meta($comercio->ID, 'fachada', true);
                    $interior = get_user_meta($comercio->ID, 'interior', true);
                    $url_web = get_user_meta($comercio->ID, 'url_web', true);
                    $url_instagram = get_user_meta($comercio->ID, 'url_instagram', true);
                    $url_twitter = get_user_meta($comercio->ID, 'url_twitter', true);
                    $url_facebook = get_user_meta($comercio->ID, 'url_facebook', true);
                    $url_tiktok = get_user_meta($comercio->ID, 'url_tiktok', true);
                    $sectores = get_user_meta($comercio->ID, 'sectores', true);
                    $opciones_guardadas = get_user_meta($comercio->ID, 'opciones_formulario', true);

                    ?>
                    <tr>
                        <td><?php echo $comercio->user_login; ?></td>
                        <td><?php echo $nombre_comercial; ?></td>
                        <td><?php echo $comercio->user_email; ?></td>
                        <td><?php echo $telefono_comercial; ?></td>
                        <td><?php echo $telefono_personal; ?></td>
                        <td><?php echo $cif; ?></td>
                        <td><?php echo $nombre_fiscal; ?></td>
                        <td><?php echo $direccion_fiscal; ?></td>
                        <td><?php echo $direccion_comercial; ?></td>
                        <td><a href="<?php echo $logotipo; ?>" target="_blank">Ver</a></td>
                        <td><a href="<?php echo $fachada; ?>" target="_blank">Ver</a></td>
                        <td><a href="<?php echo $interior; ?>" target="_blank">Ver</a></td>
                        <td class="url-column"><?php echo $url_web; ?></td>
                        <td class="url-column"><?php echo $url_instagram; ?></td>
                        <td class="url-column"><?php echo $url_twitter; ?></td>
                        <td class="url-column"><?php echo $url_facebook; ?></td>
                        <td class="url-column"><?php echo $url_tiktok; ?></td>
                        <td><?php echo implode(', ', $sectores); ?></td>
                        <td><?php echo implode(', ', $opciones_guardadas); ?></td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php 
}

function excel_page() {

    ?>
    <style>
        #botones-container {
            text-align: center;
            margin-top: 50px;
        }

        .boton {
            padding: 10px 20px;
            font-size: 18px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }

        .boton:hover {
            background-color: #0056b3;
        }

    </style>

    <script>
        jQuery(document).ready(function(){
            jQuery("#usuarios-tarjeta").click(function(){
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "excel_usuarios_tarjeta"
                    },
                    success: function(response) {
                        // Hacer algo con la respuesta del servidor (si es necesario)
                        if(response.success == true){
                            alert("Excel Usuarios tarjeta generado en la carpeta del plugin");
                        }else{
                            alert("Algo salio mal");
                        }
                    },
                    error: function(error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });
            });

            jQuery("#usuarios-comercios").click(function(){
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "excel_comercios_asociados"
                    },
                    success: function(response) {
                        // Hacer algo con la respuesta del servidor (si es necesario)
                        if(response.success == true){
                            alert("Excel Comercio Asociado generado en la carpeta del plugin");
                        }else{
                            alert("Algo salio mal");
                        }
                    },
                    error: function(error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });
            });

            jQuery("#puntos").click(function(){
                jQuery.ajax({
                    type: "POST",
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    data: {
                        action: "excel_puntos"
                    },
                    success: function(response) {
                        // Hacer algo con la respuesta del servidor (si es necesario)
                        if(response.success == true){
                            alert("Excel Solicitudes Puntos generado en la carpeta del plugin");
                        }else{
                            alert("Algo salio mal");
                        }
                    },
                    error: function(error) {
                        // Manejar errores si los hay
                        console.error(error);
                    }
                });
            });
        });
    </script>
    <div id="botones-container">
        <button id="usuarios-tarjeta" class="boton">Usuarios Tarjeta</button>
        <button id="usuarios-comercios" class="boton">Usuarios Comercios Asociados</button>
        <button id="puntos" class="boton">Puntos</button>
    </div>
    <?php
}