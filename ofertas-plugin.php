<?php
/**
 * Plugin Name: Ofertas Plugin
 * Description: Plugin de ofertas para la pagina alcalacentro.es
 * Plugin URI: https://github.com/MaTrihh/ofertas-plugin
 * Author: Ibai Ocaña Lorente
 * Version: 0.1
 * Author URI: https://github.com/MaTrihh/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Incluir archivos principales
include_once plugin_dir_path( __FILE__ ) . 'includes/pages/pages.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/functions/functions.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/Oferta.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/shortcodes.php';

register_activation_hook( __FILE__, 'ofertas_plugin_crear_tabla' );

function ofertas_plugin_agregar_estilos() {
    // Enqueue el archivo CSS
    wp_enqueue_style('op_main', plugins_url( 'includes/styles/main.css', __FILE__ ));
}

// Para cargar los estilos en el frontend del sitio
add_action('admin_enqueue_scripts', 'ofertas_plugin_agregar_estilos'); 