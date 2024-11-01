<?php
/**
 * Enqueues scripts and styles in admin
 */
function cvmh_sticky_admin_scripts() {
    wp_enqueue_style( 'cvmh-sticky-admin-style', CVMH_STICKY_ASSETS_PATH . 'css/admin.css' );
    wp_enqueue_script( 'jquery-ui-tabs' );
}

/**
 * Enqueues scripts and styles for front end
 */
function cvmh_sticky_front_enqueues() {
    wp_register_style( 'cvmh-sticky-style', CVMH_STICKY_ASSETS_PATH . 'css/front.css' );
    wp_register_script( 'cvmh-sticky-script', CVMH_STICKY_ASSETS_PATH . 'js/front.js', array( 'jquery' ) );
}

/**
 * Default args for shortcode and widget
 * 
 * @return type
 */
function cvmh_sticky_default_args() {
    $defaults = array(
        'title'          => __( 'Sticky posts', 'sticky' ),
        'stickytype'     => 'post',
        'count'          => 3,
        'showimage'      => true,
        'imagesize'      => 'thumbnail',
        'showtitle'      => true,
        'titlelength'    => 45,
        'titletag'       => 'h3',
        'showexcerpt'    => true,
        'excerptlength'  => 50,
        'showreadmore'   => true,
        'readmoretext'   => __( 'Read more', 'sticky' ),
        'readmoretype'   => 'anchor' );
        
    return apply_filters( 'cvmh_sticky_default_args', $defaults );
}

/**
 * Get sticky posts
 * 
 * @param type $params
 * @return type
 */
function cvmh_sticky_get_posts( $params ) {
    $args = array(
        'posts_per_page'      => $params['count'],
        'orderby'             => 'menu_order',
        'order'               => 'ASC',
        'post_type'           => $params['stickytype'],
        'post_status'         => 'publish',
        'ignore_sticky_posts' => true,
    );
    if ( ! empty( get_option( 'sticky_posts' ) ) )
        $args['post__in'] = get_option( 'sticky_posts' );
    $posts = get_posts( apply_filters( 'cvmh_sticky_get_posts_args', $args ) );
    return $posts;
}

/**
 * Render sticky block
 * 
 * @global type $post
 * @param type $args
 * @return string
 */
function cvmh_sticky_front_render( $args ) {
    wp_enqueue_script( 'cvmh-sticky-script' );
    wp_enqueue_style( 'cvmh-sticky-style' );
    
    $posts = cvmh_sticky_get_posts( $args );
    $nb_posts = count( $posts );

    if ( !empty( $posts ) ) :
        global $post;
        $html = '';

        $i = 0;
        foreach ( $posts as $post ) :
            setup_postdata( $post );
            $link = apply_filters( 'cvmh_sticky_link', get_permalink(), $post->ID );
            $i++;

            $html .= '<li class="item-' . $i . '">';

            $html .= apply_filters( 'cvmh_sticky_before_image', '', $post->ID );
            
            if ( $args['showimage'] ) :
                $thumbnail = get_the_post_thumbnail( $post->ID, $args['imagesize'], array( 'class' => 'sticky-img sticky-goto', 'data-url' => $link ) );
                if ( ! empty( $thumbnail ) ) :
                    $html .= $thumbnail;
                endif;
            endif;

            if ( $args['showtitle'] ) :
                $title = apply_filters( 'cvmh_sticky_title', get_the_title(), $post->ID );
                if ( ! empty( $args['titlelength'] ) and strlen( $title ) > $args['titlelength'] ) :
                    $title = substr( $title, 0, $args['titlelength'] ) . '...';
                endif;
                $html .= '<' . $args['titletag'] . '><a href="' . $link . '">' . $title . '</a></' . $args['titletag'] . '>';
            endif;

            $html .= apply_filters( 'cvmh_sticky_after_title', '', $post->ID );
            
            $html .= '<div class="sticky-content">';
            
            if ( $args['showexcerpt'] ) :
                $html .= '<div class="sticky-excerpt">' . sticky_excerpt( $args['excerptlength'] ) . '</div>';
            endif;

            if ( $args['showreadmore'] and ! empty( $args['readmoretext'] ) ) :
                if ( $args['readmoretype'] === 'button' ) :
                    $readmore = '<button class="sticky-readmore sticky-goto" data-url="' . $link . '">' . apply_filters( 'cvmh_sticky_readmore', $args['readmoretext'], $i, $post->ID ) . '</button>';
                else :
                    $readmore = '<a class="sticky-readmore" href="' . $link . '">' . apply_filters( 'cvmh_sticky_readmore', $args['readmoretext'], $i, $post->ID ) . '</a>';
                endif;
                $html .= $readmore;
            endif;

            $html .= '</div>';
            $html .= '</li>';
        endforeach;
        wp_reset_postdata();

        $title = '';
        if ( ! empty( $args['plugintitle']  ) ) :
            $title = '<h2 class="widget-title decorate">' . $args['plugintitle'] . '</h2>';
        endif;

        $sticky = $title . '<ul class="sticky-list">' . $html . '</ul>';
        
    endif;

    return $sticky;   
}

/*
 * Truncate excerpt
 */
function sticky_excerpt( $length ) {
    global $post;
    $text = $post->post_excerpt;

    if ( $text == '' ) :
        $text = get_the_content();
        $text = strip_shortcodes( $text );

        $text = apply_filters( 'the_content', $text );
        $text = str_replace( ']]>', ']]&gt;', $text );

        $text = strip_tags( $text, apply_filters( 'cvmh_sticky_excerpt_allowed_tags', '<p><a><strong><em><br>' ) );

        $words = preg_split( "/[\n\r\t ]+/", $text, $length + 1, PREG_SPLIT_NO_EMPTY );
        if ( count( $words ) > $length ) :
            array_pop( $words );
            $text = implode( ' ', $words );
            $text = $text . ' [...]';
        else :
            $text = implode( ' ', $words );
        endif;
    else :
        $text = '<p>' . nl2br( $text ) . '</p>';
    endif;
    return $text;
}