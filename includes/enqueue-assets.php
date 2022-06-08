<?php

function newtheme_newtheme_admin_scripts( ) {
    global $pagenow;
    if( $pagenow !== 'post.php') return;
    wp_enqueue_script( 'newtheme-newtheme-admin-scripts', plugins_url( 'newtheme-metaboxes/dist/assets/js/admin.js' ), array( 'jquery' ), '1.0.0', true);

    wp_enqueue_style( 'newtheme-newtheme-admin-stylesheet',  plugins_url('newtheme-metaboxes/dist/assets/css/admin.css'), array(), '1.0.0', 'all' );
}
add_action( 'admin_enqueue_scripts', 'newtheme_newtheme_admin_scripts' );