<?php
/**
 * Plugin Name: Ofertas Plugin
 * Description: Plugin de ofertas para la pagina alcalacentro.es
 * Plugin URI: https://github.com/MaTrihh/ofertas-plugin
 * Author: Ibai Ocaña Lorente
 * Version: 1.0
 * Author URI: https://github.com/MaTrihh/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define('OFERTAS_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Incluir archivos principales
include_once plugin_dir_path( __FILE__ ) . 'includes/pages/pages.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/functions/functions.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/Oferta.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/OfertaCanjeada.php';
include_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes/shortcodes.php';

register_activation_hook( __FILE__, 'ofertas_plugin_tablas' );

function ofertas_plugin_agregar_estilos_admin() {
    wp_enqueue_style( 'op_main-admin', plugins_url( 'includes/styles/main.css', __FILE__ ) );
}
add_action( 'admin_enqueue_scripts', 'ofertas_plugin_agregar_estilos_admin' );

function ofertas_plugin_agregar_estilos_front() {
    // Define la URL base de tu plugin
    $plugin_url = plugin_dir_url( __FILE__ );

    // Registra y encola el estilo CSS
    wp_enqueue_style('op_main', plugins_url( 'includes/styles/main.css', __FILE__ ));
    wp_enqueue_style( 'op_front', plugins_url( 'includes/styles/front.css', __FILE__ ) );
    wp_enqueue_style( 'op_ofertas', plugins_url( 'includes/styles/ofertas.css', __FILE__ ) );

    wp_enqueue_script('jquery');
    wp_enqueue_style('dashicons');

    // Añadir la biblioteca jQuery Validation
    wp_enqueue_script('op_jquery-validation', plugin_dir_url(__FILE__) . 'lib/jquery.validate.min.js', array('jquery'), '1.19.5', true);
    wp_enqueue_script('op_additional-methods', plugin_dir_url(__FILE__) . 'lib/additional-methods.min.js', array('jquery'), '1.19.5', true);

    wp_localize_script('my-plugin-script', 'my_ajax_object', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'ofertas_plugin_agregar_estilos_front' );


