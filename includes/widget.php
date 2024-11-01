<?php
defined( 'ABSPATH' ) or exit;

class CVMH_Sticky_Widget extends WP_Widget {

    //register our widget
    public static function register() {
        register_widget( __CLASS__ );
    }
    
    public function __construct() {
        $widget_ops = array(
            'classname' => 'cvmh-sticky', 
            'description' => __( 'A block which displays a list of sticky pages/posts/custom posts.', 'sticky' ),
        );
        parent::__construct( 'cvmh_sticky_widget', 'Sticky', $widget_ops );
    }

    public function update( $new_instance, $old_instance ) {
        $instance                   = $old_instance;
        
        $instance['title']          = strip_tags( $new_instance['title'] );
        $instance['count']          = (int) $new_instance['count'];
        $instance['stickytype']     = strip_tags( $new_instance['stickytype'] );
        $instance['showimage']      = isset( $new_instance['showimage'] ) ? (bool) $new_instance['showimage'] : false;
        $instance['imagesize']      = strip_tags( $new_instance['imagesize'] );
        $instance['showtitle']      = isset( $new_instance['showtitle'] ) ? (bool) $new_instance['showtitle'] : false;
        $instance['titletag']       = strip_tags( $new_instance['titletag'] );
        $instance['titlelength']    = (int) $new_instance['titlelength'];
        $instance['showexcerpt']    = isset( $new_instance['showexcerpt'] ) ? (bool) $new_instance['showexcerpt'] : false;
        $instance['excerptlength']  = (int) $new_instance['excerptlength'];
        $instance['showreadmore']   = isset( $new_instance['showreadmore'] ) ? (bool) $new_instance['showreadmore'] : false;
        $instance['readmoretext']   = strip_tags( $new_instance['readmoretext'] );
        $instance['readmoretype']   = strip_tags( $new_instance['readmoretype'] );

        return $instance;
    }
    
    public function form( $instance ) {
        $instance  = wp_parse_args( ( array ) $instance, cvmh_sticky_default_args() );
        extract( $instance );
        $options = json_decode( get_option( 'cvmh_sticky' ), true );
        include( CVMH_STICKY_INC_PATH . 'form.php' );
    }

    function widget( $args, $instance ) {
        extract( $args );

        echo $before_widget;
        
        if ( ! empty( $instance['title'] ) ) {
            echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
        }
        
        echo cvmh_sticky_front_render( $instance );
        
        echo $after_widget;
    }
    
}