<?php
function ofertas_plugin_agregar_menu()
{
    // Agregar un menú principal
    add_menu_page(
        __('Ofertas Plugin', 'alcalacentro.es'),
        __('Ofertas Plugin', 'alcalacentro.es'),
        'manage_options',
        'ofertas_plugin_menu',
        'ofertas_plugin_general_page',
        'dashicons-schedule',
        3
    );
    add_submenu_page(
        'ofertas_plugin_menu',
        __('Tabla Ofertas', 'alcalacentro.es'),
        __('Tabla Ofertas', 'alcalacentro.es'),
        'manage_options',
        'ofertas_plugin_admin',
        'ofertas_plugin_tabla_page'
    );
    add_submenu_page(
        'ofertas_plugin_menu',
        __('Informacion Shortcodes', 'alcalacentro.es'),
        __('Informacion Shortcodes', 'alcalacentro.es'),
        'manage_options',
        'ofertas_plugin_informacion_shortcodes',
        'ofertas_plugin_informacion_shortcodes_page'
    );
}
add_action('admin_menu', 'ofertas_plugin_agregar_menu');

