<?php
/*
 * Plugin Name: Sticky
 * Plugin URI: http://www.agence-web-cvmh.fr
 * Description: Adds sticky support for pages and/or custom posts.
 * Version: 2.5.6
 * Author: CVMH solutions
 * Author URI: http://www.agence-web-cvmh.fr
 * License: GPLv2 or later
 * Text Domain: sticky
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) or exit;

add_action( 'plugins_loaded', 'cvmh_sticky_constants', 1 );
function cvmh_sticky_constants() {
    define( 'CVMH_STICKY_VERSION'       , '2.5.6' );
    define( 'CVMH_STICKY_PATH'          , trailingslashit( plugin_dir_path( __FILE__ ) ) );
    define( 'CVMH_STICKY_URI'           , trailingslashit( plugin_dir_url( __FILE__ ) ) );
    define( 'CVMH_STICKY_INC_PATH'      , CVMH_STICKY_PATH . trailingslashit( 'includes' ) ) ;
    define( 'CVMH_STICKY_ASSETS_PATH'   , CVMH_STICKY_URI . trailingslashit( 'assets' ) ) ;
}

add_action( 'plugins_loaded', 'cvmh_sticky_i18n', 2 );
function cvmh_sticky_i18n() {
    load_plugin_textdomain( 'sticky', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'cvmh_sticky_setup', 3 );
function cvmh_sticky_setup() {
    add_post_type_support( 'page', 'excerpt' );    
}

add_action( 'plugins_loaded', 'cvmh_sticky_includes', 4 );
function cvmh_sticky_includes() {
    require_once( CVMH_STICKY_INC_PATH . '3rd-party.php' );
    require_once( CVMH_STICKY_INC_PATH . 'functions.php' );
    require_once( CVMH_STICKY_INC_PATH . 'widget.php' );
    require_once( CVMH_STICKY_INC_PATH . 'shortcode.php' );
    if ( is_admin() ) :
        require_once( CVMH_STICKY_INC_PATH . 'admin.php' );
    endif;
}

add_action( 'widgets_init', array( 'CVMH_Sticky_Widget', 'register' ) );

add_action('wp_enqueue_scripts', 'cvmh_sticky_front_enqueues' );

// Load the admin style.
add_action( 'admin_enqueue_scripts', 'cvmh_sticky_admin_scripts' );
add_action( 'customize_controls_enqueue_scripts', 'cvmh_sticky_admin_scripts' );