<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function formzu_enqueue_js() {
    wp_enqueue_script(
        'form_id_submit_button',
        plugins_url() . '/formzu-plugin/js/form_id_submit_button.js',
        array( 'jquery' ),
        filemtime( FORMZU_PLUGIN_PATH . '/js/form_id_submit_button.js' ),
        true
    );

    wp_localize_script(
        'form_id_submit_button',
        'formzu_ajax_obj',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce'   => wp_create_nonce('get_iframe_height'),
            'action'  => 'get_iframe_height',
            'email'   => get_option('admin_email'),
        )
    );
}

