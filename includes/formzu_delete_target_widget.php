<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function formzu_delete_target_widget() {
    $widgets = FormzuOptionHandler::get_option('formzu_widgets', array());

    if ( ! FormzuParamHelper::isset_key($_REQUEST, 'widget_id') ) {
        return $widgets;
    }

    $id = isset($_REQUEST['id']) ? FormzuParamHelper::validate_form_id($_REQUEST['id']) : 'No_id';

    $found_widget = FormzuOptionHandler::find_option('formzu_widgets',
        array(
            'widget_id' => $_REQUEST['widget_id'],
            'id'        => $id,
        )
    );

    if ( FormzuParamHelper::isset_key($found_widget, array('item', 'index')) ) {

        $widget_id = $found_widget['item']['widget_id'];

        FormzuOptionHandler::delete_option($widget_id);
        unset($widgets[$found_widget['index']]);

        $widgets = array_values($widgets);

        set_transient('formzu-admin-updated', __('ウィジェットを消去しました。' . $widget_id, 'formzu-admin'), 3);
        FormzuOptionHandler::update_option('formzu_widgets', $widgets);
    }
    if (empty($widget_id)) {
        return $widgets;
    }
    
    $active_widgets = get_option( 'sidebars_widgets' );

    foreach ($active_widgets as $active_key => $active_space) {
        for ($i = 0, $len = count($active_space); $i < $len; $i++) {
            if ( $active_space[$i] == $widget_id ) {

                unset($active_widgets[$active_key][$i]);
                $active_widgets[$active_key] = array_values($active_widgets[$active_key]);

                break 2;
            }
        }
    }

    update_option( 'sidebars_widgets', $active_widgets );
    return $widgets;
}

