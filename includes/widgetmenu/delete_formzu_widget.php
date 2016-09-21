<?php

function delete_formzu_widget() {
    if ( ! FormzuParamHelper::isset_key($_REQUEST, array('widget_id', 'action')) ) {
        return false;
    }
    if ($_REQUEST['action'] != 'delete_formzu_widget') {
        return false;
    }
    if ( ! FormzuParamHelper::check_referer('delete_formzu_widget-' . $_REQUEST['widget_id'], 'delete_widget_nonce')) {
        return false;
    }
    formzu_delete_target_widget();
    wp_safe_redirect( admin_url('widgets.php') );
    exit;
}
