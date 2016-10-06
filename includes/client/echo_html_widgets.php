<?php

function echo_formzu_html_widgets() {
    $widgets = FormzuOptionHandler::get_option('formzu_widgets');

    if ( ! $widgets ) {
        return false;
    }
    for ($i = 0, $len = count($widgets); $i < $len; $i++) {
        if ( ! FormzuParamHelper::isset_key($widgets[$i], array('widget_id', 'id')) ) {
            continue;
        }

        $widget_id   = $widgets[$i]['widget_id'];
        $widget_name = $widgets[$i]['name'];
        $params      = array(
            'name'          => $widget_name,
            'id'            => $widgets[$i]['id'],
            'widget_id'     => $widget_id,
            'width'         => 600,
            'height'        => 500,
            'mobile_height' => 500,
        );
        $widget_html = FormzuOptionHandler::get_option( $widget_id );

        if ( $widget_html && is_array($widget_html) ) {
            $params['html'] = $widget_html;
        }
        else {
            $params['html'] = array(
                'id'            => $widgets[$i]['id'],
                'before_widget' => '<section id="' . $widget_id . '" class="widget">',
                'widget_html'   => '',
                'before_title'  => '<h2 class="widget-title">',
                'title_html'    => $widget_name,
                'after_title'   => '</h2>',
                'content_html'  => sprintf('[formzu text="%s" thickbox="on" form_id="%s" height="%s" mobile_height="%s" tagname="a"]',
                    $widget_name,
                    $widgets[$i]['id'],
                    $widgets[$i]['height'],
                    $widgets[$i]['mobile_height']
                ),
                'after_widget'  => '</section>',
            );
            FormzuOptionHandler::update_option( $widget_id, $params['html'] );
        }
        wp_register_sidebar_widget( $widget_id, $widget_name, 'display_formzu_widget_html', array(), $params );
    }
}


function display_formzu_widget_html($args, $params) {
    $html = $params['html'];
    $echo_params = array(
        'before_widget',
        'widget_html',
        'before_title',
        'title_html',
        'after_title',
        'content_html',
        'after_widget',
    );

    foreach ($echo_params as $param) {
        if ( strpos($html[$param], 'script') || strpos($html[$param], 'iframe') ) {
            echo echo_html(do_shortcode($html[$param]));
        }
        else {
            echo do_shortcode($html[$param]);
        }
    }
}
