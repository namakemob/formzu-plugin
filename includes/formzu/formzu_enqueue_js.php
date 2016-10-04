<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function formzu_enqueue_js() {
    wp_enqueue_script(
        'formzu_button_actions',
        plugins_url() . '/formzu-wp/js/formzu_button_actions.js',
        array( 'jquery' ),
        filemtime( FORMZU_PLUGIN_PATH . '/js/formzu_button_actions.js' ),
        true
    );

    wp_enqueue_script('common');
    wp_enqueue_script('wp-lists');
    wp_enqueue_script('postbox');

    wp_localize_script(
        'formzu_button_actions',
        'formzu_ajax_obj',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('get_iframe_height'),
            'action'  => 'get_iframe_height',
            'email'   => get_option('admin_email'),
        )
    );
}

