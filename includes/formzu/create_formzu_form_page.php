<?php

function create_formzu_form_page(){
    if ( ! FormzuParamHelper::check_referer('formzu_create_page', 'create_page_nonce')) {
        return false;
    }

    $action = FormzuParamHelper::get_REQ('action', false);

    if (!$action) {
        return false;
    }
    if ('create_formzu_page' != $action) {
        return false;
    }
    if ( ! FormzuParamHelper::isset_key($_REQUEST, array('name', 'id')) ) {
        return false;
    }

    $form_name = $_REQUEST['name'];
    $form_id = $_REQUEST['id'];
    $form_height = FormzuParamHelper::get_REQ('height', 600);
    $form_mobile_height = FormzuParamHelper::get_REQ('mobile_height', 700);

    $post_data = array(
        'post_title' => $form_name,
        'post_content' => '[formzu form_id="' . $form_id . '" height="' . $form_height . '" mobile_height="' . $form_mobile_height . '" tagname="iframe"]',
        'post_name' => $form_id,
        'post_type' => 'page',
    );
    $post_id = wp_insert_post( $post_data, true );

    wp_safe_redirect( admin_url('post.php') . '?post=' . $post_id . '&action=edit' );
    exit;
}

