<?php
function ofertas_plugin_agregar_menu() {
    // Agregar un menú principal
    add_menu_page(
        'Ofertas Plugin',           // Título de la página
        'Ofertas Plugin',           // Título del menú
        'manage_options',           // Capacidad requerida para ver el menú
        'ofertas_plugin_admin',     // Slug de la página
        'ofertas_plugin_pagina_principal', // Función de callback para mostrar la página
        'dashicons-megaphone'       // Ícono del menú (puedes cambiarlo según tus necesidades)
    );

    // Agregar una subpágina
    add_submenu_page(
        'ofertas_plugin_admin',     // Slug de la página padre
        'Tabla Ofertas',            // Título de la página
        'Tabla Ofertas',            // Título del menú
        'manage_options',           // Capacidad requerida para ver la página
        'ofertas_plugin_tabla', // Slug de la página
        'ofertas_plugin_tabla_page' // Función de callback para mostrar la página
    );
}
add_action('admin_menu', 'ofertas_plugin_agregar_menu');