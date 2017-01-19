<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function set_formzu_html_widgets() {
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

        if ($widget_html && is_array($widget_html)) {
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
                'content_html'  => sprintf('[formzu text="%s" thickbox="on" form_id="%s" tagname="a"]',
                    $widget_name,
                    $widgets[$i]['id']
                ),
                'after_widget'  => '</section>',
            );

            FormzuOptionHandler::update_option( $widget_id, $params['html'] );
        }

        $args = array();
        $args['description'] = 'フォームズのHTMLウィジェット';

        wp_register_sidebar_widget(
            $widget_id,
            $widget_name,
            'display_formzu_widget_html',
            $args,
            $params
        );

        //$callback_func = create_function('$widget_id', 'return setup_formzu_widget_control($widget_id);');

        wp_register_widget_control(
            $widget_id,
            $widget_name,
            //call_user_func('setup_formzu_widget_control', $widget_id),
            //$callback_func,
            create_function('', 'return setup_formzu_widget_control(\'' . strval($widget_id) . '\');'),
            $params
        );

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
        if (strpos($html[$param], 'script') || strpos($html[$param], 'iframe')) {
            echo echo_html(do_shortcode($html[$param]));
        }
        else {
            echo do_shortcode($html[$param]);
        }
    }
}


function setup_formzu_widget_control($widget_id) {
    if (isset($_POST['submitted'])) {
        $widget_html = array(
            'before_widget' => str_replace('\\', '', $_POST['before_widget']),
            'widget_html'   => str_replace('\\', '', $_POST['widget_html']),
            'before_title'  => str_replace('\\', '', $_POST['before_title']),
            'title_html'    => str_replace('\\', '', $_POST['title_html']),
            'after_title'   => str_replace('\\', '', $_POST['after_title']),
            'content_html'  => str_replace('\\', '', $_POST['content_html']),
            'after_widget'  => str_replace('\\', '', $_POST['after_widget']),
        );
        FormzuOptionHandler::update_option( $widget_id, $widget_html );
    }
    else {
        $widget_html = FormzuOptionHandler::get_option( $widget_id );
    }

    $input_str = '<input style="font-size:12px;" type="text" name="%1$s" value="%2$s" class="large-text code" />';
    echo '<p>';
    echo sprintf($input_str, 'before_widget', esc_attr($widget_html['before_widget']));
    echo sprintf($input_str, 'widget_html',   esc_attr($widget_html['widget_html']));
    echo sprintf($input_str, 'before_title',  esc_attr($widget_html['before_title']));
    echo sprintf($input_str, 'title_html',    esc_attr($widget_html['title_html']));
    echo sprintf($input_str, 'after_title',   esc_attr($widget_html['after_title']));
    echo sprintf($input_str, 'content_html',  esc_attr($widget_html['content_html']));
    echo sprintf($input_str, 'after_widget',  esc_attr($widget_html['after_widget']));
    echo '</p>';

    echo '<p>';
    echo '<a href="' . wp_nonce_url(admin_url('widgets.php') . '?action=delete_formzu_widget&widget_id=' . $widget_id, 'delete_formzu_widget-' . $widget_id, 'delete_widget_nonce') . '">' . __('このウィジェットを完全に消去', 'formzu-admin') . '</a>';
    echo '</p>';
    echo '<input type="hidden" name="submitted" value="1" />';
}

