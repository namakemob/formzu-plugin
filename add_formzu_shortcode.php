<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function add_formzu_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'form_id'       => 'No_form_id',
        'width'         => '600',
        'height'        => '',
        'mobile_height' => '',
        'tagname'       => 'iframe',
        'text'          => '',
        'thickbox'      => 'off',
        'new_window'    => 'off',
        'id'            => '',
        'class'         => '',
    ), $atts, 'formzu' );

    $thickbox_on   = FALSE;
    $new_window_on = FALSE;
    $is_mobile     = wp_is_mobile();

    if ( $atts['tagname'] == 'a' && ! $is_mobile ) {
        if ( $atts['thickbox'] == 'on' || strpos($atts['class'], 'thickbox') !== false ) {
            $thickbox_on = TRUE;
        }
        elseif ( $atts['new_window'] == 'on' ) {
            $new_window_on = TRUE;
        }
    }

    $opts = array(
        'is_mobile'     => $is_mobile,
        'thickbox_on'   => $thickbox_on,
        'new_window_on' => $new_window_on,
    );

    $height = get_formzu_form_height($atts['form_id'], $is_mobile);

    $shortcode_format = '<%tagname% %link% %id% %class% %style% %additional_atts%>%text%</%tagname%>';

    $shortcode_format = str_replace('%tagname%', $atts['tagname'], $shortcode_format);
    $shortcode_format = set_link_to_formzu($atts, $height, $opts, $shortcode_format);
    $shortcode_format = formzu_set_id_of_element($atts['id'], $shortcode_format);
    $shortcode_format = formzu_set_class_of_element($atts['class'], $opts, $shortcode_format);
    $shortcode_format = formzu_set_style_of_element($atts['width'], $height, $opts, $shortcode_format);
    $shortcode_format = formzu_set_additional_atts($atts['tagname'], $atts['form_id'], $height, $opts, $shortcode_format);
    $shortcode_format = str_replace('%text%', $atts['text'], $shortcode_format);

    return $shortcode_format;
}


function get_formzu_form_height($form_id, $is_mobile) {
    $height_prop_name = $is_mobile ? 'mobile_height' : 'height';

    if ( empty($atts[$height_prop_name]) ) {
        $height = get_height_from_formzu_option($height_prop_name, $form_id);
    }
    else {
        $height = $atts[$height_prop_name];
    }
    if ( ! $height ) {
        $height = $is_mobile ? '900' : '800';
    }
    return $height;
}


function get_height_from_formzu_option($height_prop_name, $form_id) {
    $found_form = FormzuOptionHandler::find_option('form_data', array('id' => $form_id));

    if ( ! $found_form ) {
        return false;
    }
    if ( ! isset($found_form['item'][$height_prop_name]) ) {
        return false;
    }
    return $found_form['item'][$height_prop_name];
}


function set_link_to_formzu($atts, $height, $opts, $format) {
    $link = '';

    if ($atts['tagname'] === 'a') {
        $link = 'href="';
    }
    elseif ($atts['tagname'] === 'iframe') {
        $link = 'src="';
    }


    if ( $opts['is_mobile'] ) {
        $link .= 'https://ws.formzu.net/sfgen/' . $atts['form_id'];
    }
    elseif ( $opts['new_window_on'] ) {
        $link = 'href="javascript:void(0)';
    }
    else {
        $link .= 'https://ws.formzu.net/fgen/' . $atts['form_id'];
    }

    if ( $opts['thickbox_on'] ) {
        $link .= '?TB_iframe=true&width=' . $atts['width'] . '&height=' . $height;
    }

    $link .= '"';

    $shortcode_format = str_replace('%link%', $link, $format);

    return $shortcode_format;
}


function formzu_set_id_of_element($elem_id, $format) {
    $id = '';

    if ( ! empty($elem_id) ) {
        $id = ' id="' . $elem_id . '"';
    }

    $shortcode_format = str_replace('%id%', $id, $format);

    return $shortcode_format;
}


function formzu_set_class_of_element($elem_class, $opts, $format) {
    $class = '';

    if ( ! empty($elem_class) ) {
        $class = ' class="' . $elem_class;
    }
    if ( $opts['thickbox_on'] && ! $opts['is_mobile'] ) {
        if ( $class === '' ) {
            $class = ' class="';
        }
        $class .= ' thickbox';
    }
    if ( $class !== '' ) {
        $class .= '"';
    }

    $shortcode_format = str_replace('%class%', $class, $format);

    return $shortcode_format;
}


function formzu_set_style_of_element($width, $height, $opts, $format) {
    $style = '';

    if ( ! $opts['new_window_on'] ) {
        $style = ' style="height: ' . $height . 'px; max-width: ' . $width . 'px; width: 100%; border: 0;"';
    }

    $shortcode_format = str_replace('%style%', $style, $format);

    return $shortcode_format;
}


function formzu_set_additional_atts($tagname, $form_id, $height, $opts, $format) {
    $additional_atts = '';

    if ($tagname === 'a') {
        $additional_atts .= ' target="_blank"';
    }
    if ( ! $opts['is_mobile'] && $opts['new_window_on'] ) {
        $additional_atts .= ' onClick="javascript:window.open(\''
             . 'https://ws.formzu.net/fgen/' . $form_id . '\', '
             . '\'mailform1\', \'toolbar=no, location=no, status=yes, menubar=yes, resizable=yes, scrollbars=yes, '
             . 'width=600, height=' . $height . ', top=100, left=100\')"';
    }
    if ( $opts['thickbox_on'] ) {
        $additional_atts .= ' data-origin-height="' . $height . '"';
    }

    $shortcode_format = str_replace('%additional_atts%', $additional_atts, $format);

    return $shortcode_format;
}

