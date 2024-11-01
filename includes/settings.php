<?php
# Exit if accessed directly
defined( 'ABSPATH' ) or exit;

$message      = '';
$notice_class = 'updated';
$notice_style = 'display:none;';

if ( $_REQUEST['action'] === 'save' ) :
        // nonce test
        if ( !wp_verify_nonce( $_POST['cvmh_sticky_settings_nonce'], 'cvmh_sticky_settings' ) ):
            $message      = __( 'Nonce error.', 'sticky' );
            $notice_class = 'error';
        // rights test 
        elseif ( ! current_user_can( 'manage_options' ) ):
            $message      = '<p><strong>' . __( 'You do not have permission to change the settings for this extension.', 'sticky' ) . '</strong></p>';
            $notice_class = 'error';
        else:
            cvmh_sticky_save_options();
            $message      = '<p><strong>' . __( 'Settings saved.', 'sticky' ) . '</strong></p>';
            $notice_style = 'display:block;';
        endif;
endif;

$options = json_decode( get_option( 'cvmh_sticky' ), true );
?>

<div id="message" class="<?php echo $notice_class; ?> fade" style="<?php echo $notice_style; ?>"><?php echo $message; ?></div>


<div class="wrap">
    
    <h1><?php _e( 'Sticky', 'sticky' ); ?></h1>
    
    <div id="welcome-panel" class="welcome-panel cvmh-slideshow-welcome-panel">
        <p><?php _e( 'To display sticky posts, use the widget or shortcode [cvmh-sticky].', 'sticky' ); ?></p>
    </div>

    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <input type="hidden" name="action" value="save" />
        <?php wp_nonce_field( 'cvmh_sticky_settings', 'cvmh_sticky_settings_nonce' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <?php _e( 'Post types', 'sticky' ); ?>
                </th>
                <td>
                    <?php
                    $args = array( 'public' => true );
                    $post_types = get_post_types( $args, 'objects' );
                    unset( $post_types['post'] );
                    unset( $post_types['attachment'] );
                    $post_types = remove_3rdparty_types( $post_types );
                    ?>
                    <?php foreach ( $post_types  as $post_type_name => $post_type ) : ?>
                        <p>
                            <label for="post-type-<?php echo $post_type_name; ?>">
                                <input id="post-type-<?php echo $post_type_name; ?>" type="checkbox" name="options[post_types][]" value="<?php echo $post_type_name; ?>" <?php echo in_array( $post_type_name, $options['post_types'] ) ? ' checked="checked"' : ''; ?> />
                                <?php echo $post_type->labels->name; ?>
                            </label>
                        </p>
                    <?php endforeach; ?>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input id="submit" class="button button-primary" type="submit" value="<?php _e( 'Save changes', 'sticky' ); ?>" name="submit" />
        </p>
    </form>
    
</div><!-- .wrap -->