<?php
defined( 'ABSPATH' ) or exit;
    
add_shortcode( 'cvmh-sticky', 'cvmh_sticky_front_shortcode' );
function cvmh_sticky_front_shortcode( $atts ) {
    
    $args = shortcode_atts( cvmh_sticky_default_args(), $atts );
    return cvmh_sticky_front_render( $args );
    
}