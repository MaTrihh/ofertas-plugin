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
include_once plugin_dir_path( __FILE__ ) . 'includes/pages/menu.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/pages/ofertas-page.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/functions/initial-sql-script.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/functions/api.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/Oferta.php';

register_activation_hook( __FILE__, 'ofertas_plugin_crear_tabla' );