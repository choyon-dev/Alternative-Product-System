<?php
/**
 * Plugin Name: Elementor Alternative Products
 * Description: A custom Elementor widget to display alternative product loops in list view.
 * Version: 1.1
 * Author: Nirman Technologies
 * Developer: Choyon
 * Text Domain: alternative-products-widget
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function register_alternative_products_widget( $widgets_manager ) {
    require_once( __DIR__ . '/includes/widget-alternative-products.php' );
    $widgets_manager->register( new \Alternative_Products_Widget() );
}
add_action( 'elementor/widgets/register', 'register_alternative_products_widget' );

function enqueue_widget_styles() {
    wp_enqueue_style( 'alternative-products-widget-style', plugins_url( '/assets/css/style.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'enqueue_widget_styles' );
