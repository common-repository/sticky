<?php
defined( 'ABSPATH' ) or exit;

/**
 * Admin initialisation
 */
add_action( 'admin_menu', 'cvmh_sticky_admin_menu' );
function cvmh_sticky_admin_menu() {
    add_options_page( 'Sticky', 'Sticky', 'manage_options', 'cvmh-sticky', 'cvmh_sticky_admin_settings_page' );
}

/**
 * Enqueues scripts
 */
add_action( 'admin_enqueue_scripts', 'cvmh_sticky_admin_enqueue_scripts' );
function cvmh_sticky_admin_enqueue_scripts() {

    $screen = get_current_screen();
    $options = json_decode( get_option( 'cvmh_sticky' ), true );
    
    
    // Only continue if this is an edit screen for a post type in sticky options
    if ( !in_array( $screen->base, array( 'post', 'edit' ) ) or !in_array( $screen->post_type, $options['post_types'] ) ) :
        return;
    endif;

    // Editing an individual custom post
    if ( $screen->base == 'post' ) :
        $js_vars = array(
            'screen' => 'post',
            'is_sticky' => is_sticky() ? 1 : 0,
            'checked_attribute' => checked( is_sticky(), true, false ),
            'label_text' => __( 'Stick this post to the front page', 'sticky' ),
            'sticky_visibility_text' => __( 'Public, Sticky', 'sticky' )
        );

    // Browsing custom posts
    else :
        global $wpdb;

        $sticky_posts = implode( ', ', array_map( 'absint', ( array ) get_option( 'sticky_posts' ) ) );
        $sticky_count = $sticky_posts
            ? $wpdb->get_var( $wpdb->prepare( "SELECT COUNT( 1 ) FROM $wpdb->posts WHERE post_type = %s AND post_status NOT IN ('trash', 'auto-draft') AND ID IN ($sticky_posts)", $screen->post_type ) )
            : 0;

        $post_type_object = get_post_type_object( $screen->post_type );

        $js_vars = array(
            'screen' => 'edit',
            'post_type' => $screen->post_type,
            'post_type_hierarchical' => $post_type_object->hierarchical,
            'status_label_text' => __( 'Status' ),
            'label_text' => __( 'Make this post sticky', 'sticky' ),
            'sticky_text' => __( 'Sticky', 'sticky' ),
            'sticky_count' => $sticky_count,
            'sticky_posts' => explode( ', ', $sticky_posts ),
        );
    endif;

    // Enqueue js and pass it specified variables
    wp_enqueue_script( 'cvmh-sticky-admin', CVMH_STICKY_ASSETS_PATH . 'js/admin.js', array( 'jquery' ) );
    wp_localize_script( 'cvmh-sticky-admin', 'sticky', $js_vars );

}

/**
 * Admin settings page
 */
function cvmh_sticky_admin_settings_page() {
    require_once( CVMH_STICKY_INC_PATH . 'settings.php' );
}

/**
 * Settings link in extension list
 * 
 * @param type $links
 * @return type
 */
add_filter( 'plugin_action_links_sticky/sticky.php', 'cvmh_sticky_admin_add_action_links' );
function cvmh_sticky_admin_add_action_links( $links ) {
    array_unshift(
        $links,
        '<a href="' . admin_url( 'admin.php?page=cvmh-sticky' ) . '">' . __( 'Settings', 'sticky' ) . '</a>'
    );
    return $links;
}


/**
 * Save options
 * 
 * @since 1.0
 */
function cvmh_sticky_save_options() {
    foreach ( $_REQUEST['options'] as $key => $value ) :
        if ( is_array( $value ) ) :
            foreach ( $value as $tkey => $tvalue ) :
                $tab_options[$key][$tkey] = esc_attr( $tvalue );
            endforeach;
        else:
            $tab_options[$key] = esc_attr( $value );
        endif;
    endforeach;
    update_option( 'cvmh_sticky', json_encode( $tab_options ) );
}