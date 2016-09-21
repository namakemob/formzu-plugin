<?php

function formzu_navmenu_enqueue_js() {
    wp_enqueue_script(
        'formzu_navmenu_submit_button',
        plugins_url() . '/formzu-plugin/js/formzu_navmenu_submit_button.js',
        array( 'jquery' ),
        filemtime( FORMZU_PLUGIN_JS_PATH . '/formzu_navmenu_submit_button.js'),
        true
    );

    wp_localize_script(
        'formzu_navmenu_submit_button',
        'formzu_ajax_obj',
        array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( FORMZU_NAVMENU_NONCE),
            'action' => FORMZU_NAVMENU_NONCE,
            'metabox_id' => FORMZU_NAVMENU_METABOX_ID,
            'select_id' => FORMZU_NAVMENU_SELECT_ID,
            'submit_id' => FORMZU_NAVMENU_SUBMIT_ID,
        )
    );
}

