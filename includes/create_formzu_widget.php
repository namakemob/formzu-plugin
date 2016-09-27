<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function create_formzu_widget(){
    $widgets = FormzuOptionHandler::get_option('formzu_widgets', array());

    if ( ! FormzuParamHelper::isset_key($_REQUEST, array('id', 'name', 'action')) ) {
        return false;
    }
    if ( $_REQUEST['action'] != 'create_formzu_widget' ) {
        return false;
    }

    $widget_id = $_REQUEST['id'];
    $widget_name = $_REQUEST['name'];

    if ( ! FormzuParamHelper::check_referer('create_formzu_widget-' . $widget_id, 'create_widget_nonce') ) {
        return false;
    }

    $found_widget = FormzuOptionHandler::find_option('formzu_widgets',
        array(
            'id' => $widget_id,
        )
    );

    if ($found_widget) {
        set_transient( 'formzu-admin-error',  __( '既にウィジェットが作成されている可能性があります。', 'formzu-admin' ) . ' : ' . $widget_name, 3 );
        wp_safe_redirect( admin_url('widgets.php') . '?action=created_formzu_widget&name=' . $widget_name . '&id=' . $widget_id );
        exit;
        return false;
    }

    $data = array(
        'name'          => $widget_name,
        'id'            => $widget_id,
        'widget_id'     => 'formzu_widget-' . strval(count($widgets) + 2),
        'height'        => $_REQUEST['height'],
        'mobile_height' => $_REQUEST['mobile_height'],
    );
    $widgets[] = $data;

    set_transient( 'formzu-admin-updated', __( $widget_name . 'のウィジェットを作成しました。', 'formzu-admin' ), 3 );
    FormzuOptionHandler::update_option( 'formzu_widgets', $widgets );
    wp_safe_redirect( admin_url('widgets.php') . '?action=created_formzu_widget&name=' . $data['name'] . '&id=' . $data['id'] );
    exit;
}

