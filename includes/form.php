<?php defined( 'ABSPATH' ) or exit; ?>

<script>
    jQuery( function( $ ) {

        var $form = $( ".cvmh-widget-form-tabs" );

        $form.tabs().addClass( "ui-tabs-vertical" );

        // Add custom class
        $form.closest( ".widget-inside" ).addClass( "cvmh-bg" );
    });
</script>

<div class="cvmh-widget-form-tabs">

    <ul class="cvmh-tabs">
        <li><a href="#tab-1"><?php _e( 'General', 'sticky' ); ?></a></li>
        <li><a href="#tab-2"><?php _e( 'Posts', 'sticky' ); ?></a></li>
        <li><a href="#tab-3"><?php _e( 'Thumbnail', 'sticky' ); ?></a></li>
        <li><a href="#tab-4"><?php _e( 'Content', 'sticky' ); ?></a></li>
    </ul>

    <div class="cvmh-tabs-content">

        <div id="tab-1" class="cvmh-tab-content">
            <p>
                <?php _e( 'Title:', 'sticky' ); ?>
                <input class="widefat"
                       name="<?php echo $this->get_field_name( 'title' ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $instance['title'] ); ?>" />

            </p>
        </div><!-- #tab-1 -->

        <div id="tab-2" class="cvmh-tab-content">
            <p>
                <?php _e( 'Post Type:', 'sticky' ); ?>
                <select class="widefat" id="<?php echo $this->get_field_id( 'stickytype' ); ?>" name="<?php echo $this->get_field_name( 'stickytype' ); ?>">
                    <option value="post" <?php selected( $instance['stickytype'], 'post' ); ?>><?php _e( 'Posts' ); ?></option>
                    <?php foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) : ?>
                        <?php if ( in_array( $post_type->name, $options['post_types'] ) ) : ?>
                            <option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $instance['stickytype'], $post_type->name ); ?>><?php echo esc_html( $post_type->labels->name ); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <?php _e( 'Number of posts to show:', 'sticky' ); ?>
                <input class="widefat"
                       name="<?php echo $this->get_field_name( 'count' ); ?>"
                       type="number" step="1" min="-1"
                       value="<?php echo (int) ( $instance['count'] ); ?>" />
                <small>-1 <?php _e( 'to show all posts.', 'sticky' ); ?></small>
            </p>
        </div><!-- #tab-2 -->

        <div id="tab-3" class="cvmh-tab-content">
            <p>
                <input class="checkbox" type="checkbox" <?php checked( $instance['showimage'] ); ?> id="<?php echo $this->get_field_id( 'showimage' ); ?>" name="<?php echo $this->get_field_name( 'showimage' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'showimage' ); ?>">
                        <?php _e( 'Display thumbnail', 'sticky' ); ?>
                </label>
            </p>
            <p>
                <?php _e( 'Thumbnail size:', 'sticky' ); ?><br />
                <select name="<?php echo $this->get_field_name( 'imagesize' ); ?>">
                    <?php $sizes = get_intermediate_image_sizes(); ?>
                    <?php foreach ( $sizes as $size ) : ?>
                        <option value="<?php echo $size; ?>" <?php selected( $instance['imagesize'], $size ); ?>><?php echo $size; ?></option>
                    <?php endforeach; ?>
                </select>
            </p>
        </div><!-- #tab-3 -->

        <div id="tab-4" class="cvmh-tab-content">
            <p>
                <input class="checkbox" type="checkbox" <?php checked( $instance['showtitle'] ); ?> id="<?php echo $this->get_field_id( 'showtitle' ); ?>" name="<?php echo $this->get_field_name( 'showtitle' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'showtitle' ); ?>">
                        <?php _e( 'Display post title', 'sticky' ); ?>
                </label>
            </p>
            <p>
                <?php _e( 'Title length:', 'sticky' ); ?>
                <input class="widefat"
                       name="<?php echo $this->get_field_name( 'titlelength' ); ?>"
                       type="number" step="1" min="0"
                       value="<?php echo (int) ( $instance['titlelength'] ); ?>" />
                <small><?php _e( 'Number of characters.', 'sticky' ); ?></small>
            </p>
            <p>
                <?php _e( 'Title tag:', 'sticky' ); ?>
                <input class="widefat"
                       name="<?php echo $this->get_field_name( 'titletag' ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $instance['titletag'] ); ?>" />
                <small><?php _e( 'eg. h3 for &lt;h3&gt;.', 'sticky' ); ?></small>
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked( $instance['showexcerpt'] ); ?> id="<?php echo $this->get_field_id( 'showexcerpt' ); ?>" name="<?php echo $this->get_field_name( 'showexcerpt' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'showexcerpt' ); ?>">
                        <?php _e( 'Display post excerpt', 'sticky' ); ?>
                </label>
            </p>
            <p>
                <?php _e( 'Excerpt length:', 'sticky' ); ?>
                <input class="widefat"
                       name="<?php echo $this->get_field_name( 'excerptlength' ); ?>"
                       type="number" step="1" min="0"
                       value="<?php echo (int) ( $instance['excerptlength'] ); ?>" />
                <small><?php _e( 'Number of words.', 'sticky' ); ?></small>
            </p>
            <p>
                <input class="checkbox" type="checkbox" <?php checked( $instance['showreadmore'] ); ?> id="<?php echo $this->get_field_id( 'showreadmore' ); ?>" name="<?php echo $this->get_field_name( 'showreadmore' ); ?>" />
                <label for="<?php echo $this->get_field_id( 'showreadmore' ); ?>">
                        <?php _e( 'Display "read more" link', 'sticky' ); ?>
                </label>
            </p>
            <p>
                <?php _e( '"Read more" link tag:', 'sticky' ); ?>
                <br />
                <input type="radio" 
                       name="<?php echo $this->get_field_name( 'readmoretype' ); ?>" 
                       value="anchor" <?php checked( $instance['readmoretype'], 'anchor' ); ?> ><?php _e( 'Anchor', 'sticky' ); ?>
                &nbsp;&nbsp;&nbsp;
                <input type="radio" 
                       name="<?php echo $this->get_field_name( 'readmoretype' ); ?>" 
                       value="button" <?php checked( $instance['readmoretype'], 'button' ); ?> ><?php _e( 'Button', 'sticky' ); ?>
                &nbsp;&nbsp;&nbsp;
            </p>
            <p>
                <?php _e( '"Read more" link text:', 'sticky' ); ?>
                <input class="widefat"
                       name="<?php echo $this->get_field_name( 'readmoretext' ); ?>"
                       type="text"
                       value="<?php echo esc_attr( $instance['readmoretext'] ); ?>" />
            </p>
        </div><!-- #tab-4 -->

    </div><!-- .cvmh-tabs-content -->
    
</div><!-- .cvmh-widget-form-tabs -->