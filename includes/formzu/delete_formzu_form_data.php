<?php

if ( ! defined('FORMZU_PLUGIN_PHP') ) {
    die();
}

function delete_formzu_form_data() {
    if ( ! FormzuParamHelper::isset_key($_REQUEST, array('action', 'delete_nonce', 'id', 'number')) ) {
        return false;
    }

    $action = FormzuParamHelper::get_REQ('action', false);

    if ( 'delete_form' != $action ) {
        return false;
    }
    if ( ! FormzuParamHelper::check_referer('delete_form-' . $_REQUEST['id'], 'delete_nonce') ) {
        return false;
    }

    $form_data  = FormzuOptionHandler::get_option('form_data');
    $form_data  = array_values( $form_data );
    $delete_num = $_REQUEST['number'];
    $delete_id  = $_REQUEST['id'];

    if ( isset($form_data[$delete_num]['id']) && $form_data[$delete_num]['id'] == $delete_id ) {
        set_transient( 'formzu-admin-updated', '<a href="https://ws.formzu.net/fgen/' . $delete_id . '/" target="_blank">'. $form_data[$delete_num]['name'] . '</a>' . __( ' を削除しました。'), 3 );

        unset( $form_data[$delete_num] );
        $form_data = array_values( $form_data );

    }
    else {
        set_transient( 'formzu-admin-error', '<a href="https://ws.formzu.net/fgen/' . $delete_id . '/" target="_blank">対象フォーム</a>' . __( ' のデータがありませんでした。'), 3 );
    }
    for ($i = 0, $len = count($form_data); $i < $len; $i++) {

        $form_data[$i]['number'] = $i;

    }
    FormzuOptionHandler::update_option('form_data', $form_data);

    formzu_delete_target_widget();

    $default_widgets = get_option('widget_formzu_default_widget');

    foreach ($default_widgets as $key => $value) {
        if ( ! isset($default_widgets[$key]['form_widget_data']) ) {
            continue;
        }

        $w_data = $default_widgets[$key]['form_widget_data'];

        if (strpos($w_data, $_REQUEST['id']) !== false) {

            unset( $default_widgets[$key] );
            $default_widgets = array_values($default_widgets);

        }
    }
    update_option('widget_formzu_default_widget', $default_widgets);
    wp_safe_redirect( menu_page_url( 'formzu-admin' ) );
    exit;
}

