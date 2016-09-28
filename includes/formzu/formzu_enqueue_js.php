<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function formzu_enqueue_js() {
    wp_enqueue_script(
        'formzu_button_actions.js',
        plugins_url() . '/formzu-plugin/js/formzu_button_actions.js.js',
        array( 'jquery' ),
        filemtime( FORMZU_PLUGIN_PATH . '/js/formzu_button_actions.js.js' ),
        true
    );

    wp_localize_script(
        'formzu_button_actions.js',
        'formzu_ajax_obj',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('get_iframe_height'),
            'action'  => 'get_iframe_height',
            'email'   => get_option('admin_email'),
        )
    );
}

