<?php
defined( 'ABSPATH' ) or exit;

/**
 * Remove 3rd party post types we don't want
 * 
 * @param type $post_types
 * @return type
 */
function remove_3rdparty_types( $post_types ) {
    unset( $post_types['cvmh_slideshow'] );
    unset( $post_types['ml-slider'] );
    return $post_types;
}
