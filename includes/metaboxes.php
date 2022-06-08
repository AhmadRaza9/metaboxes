<?php

function newtheme_add_meta_box() {
    add_meta_box( 
        'newtheme_post_metabox', 
        'Post Settings', 
        'newtheme_post_metabox_html', 
        'post', 
        'normal', 
        'default');
}

add_action( 'add_meta_boxes', 'newtheme_add_meta_box' );

function newtheme_post_metabox_html($post) {
    $subtitle = get_post_meta($post->ID, '_newtheme_post_subtitle', true);
    $layout = get_post_meta($post->ID, '_newtheme_post_layout', true);
    wp_nonce_field( 'newtheme_update_post_metabox', 'newtheme_update_post_nonce' );
    ?>
    <p>
        <label for="newtheme_post_metabox_html"><?php esc_html_e( 'Post Subtitle', 'newtheme-newtheme' ); ?></label>
        <br />
        <input class="widefat" type="text" name="newtheme_post_subtitle_field" id="newtheme_post_metabox_html" value="<?php echo esc_attr( $subtitle ); ?>" />
    </p>
    <p>
        <label for="newtheme_post_layout_field"><?php esc_html_e( 'Layout', 'newtheme-newtheme' ); ?></label>
        <select name="newtheme_post_layout_field" id="newtheme_post_layout_field" class="widefat">
            <option <?php selected( $layout, 'full' ); ?> value="full"><?php esc_html_e( 'Full Width', 'newtheme-newtheme' ); ?></option>
            <option <?php selected( $layout, 'sidebar' ); ?> value="sidebar"><?php esc_html_e( 'Post With Sidebar', 'newtheme-newtheme' ); ?></option>
        </select>
    </p>
    <?php
}

function newtheme_save_post_metabox($post_id, $post) {

    $edit_cap = get_post_type_object( $post->post_type )->cap->edit_post;
    if( !current_user_can( $edit_cap, $post_id )) {
        return;
    }
    if( !isset( $_POST['newtheme_update_post_nonce']) || !wp_verify_nonce( $_POST['newtheme_update_post_nonce'], 'newtheme_update_post_metabox' )) {
        return;
    }
    
    if(array_key_exists('newtheme_post_subtitle_field', $_POST)) {
        update_post_meta( 
            $post_id, 
            '_newtheme_post_subtitle', 
            sanitize_text_field($_POST['newtheme_post_subtitle_field'])
        );
    }

    if(array_key_exists('newtheme_post_layout_field', $_POST)) {
        update_post_meta( 
            $post_id, 
            '_newtheme_post_layout', 
            sanitize_text_field($_POST['newtheme_post_layout_field'])
        );
    }
}

add_action( 'save_post', 'newtheme_save_post_metabox', 10, 2 );