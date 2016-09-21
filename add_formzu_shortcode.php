<?php

function add_formzu_shortcode( $atts ) {
    //TODO: ###import###を有効化

    $atts = shortcode_atts( array(
        'form_id'       => 'No_form_id',
        'width'         => '600',
        'height'        => '800',
        'mobile_height' => '900',
        'tagname'       => 'iframe',
        'text'          => '',
        'thickbox'      => 'off',
        'new_window'    => 'off',
        'id'            => '',
        'class'         => '',
    ), $atts, 'formzu' );

    $thickbox_on = FALSE;
    $new_window_on = FALSE;
    $is_mobile = wp_is_mobile();

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

    $height = $atts['height'];

    if ( $is_mobile ) {
        $height = $atts['mobile_height'];
    }

    $url = 'https://ws.formzu.net/fgen/' . $atts['form_id'];
    $shortcode_format = '<%tagname% %link% %id% %class% %style% %additional_atts%>%text%</%tagname%>';

    $shortcode_format = str_replace('%tagname%', $atts['tagname'], $shortcode_format);
    $shortcode_format = set_link_to_formzu($atts, $url, $height, $opts, $shortcode_format);
    $shortcode_format = set_id_of_element($atts['id'], $shortcode_format);
    $shortcode_format = set_class_of_element($atts['class'], $opts, $shortcode_format);
    $shortcode_format = set_style_of_element($atts['width'], $height, $opts, $shortcode_format);
    $shortcode_format = set_additional_atts($atts['tagname'], $url, $height, $opts, $shortcode_format);
    $shortcode_format = str_replace('%text%', $atts['text'], $shortcode_format);

    return $shortcode_format;
}


function set_link_to_formzu($atts, $url, $height, $opts, $format) {
    $link = '';

    if ($atts['tagname'] === 'a') {
        $link = 'href="';
    }
    elseif ($atts['tagname'] === 'iframe') {
        $link = 'src="';
    }

    $link .= $url;

    if ( $opts['is_mobile'] ) {
        $link .= 'https://ws.formzu.net/sfgen/' . $atts['form_id'];
    }
    elseif ( $opts['new_window_on'] ) {
        $link = 'href="javascript:void(0)';
    }

    if ( $opts['thickbox_on'] ) {
        $link .= '?TB_iframe=true&width=' . $atts['width'] . '&height=' . $height;
    }

    $link .= '"';

    $shortcode_format = str_replace('%link%', $link, $format);

    return $shortcode_format;
}


function set_id_of_element($elem_id, $format) {
    $id = '';

    if ( ! empty($elem_id) ) {
        $id = ' id="' . $elem_id . '"';
    }

    $shortcode_format = str_replace('%id%', $id, $format);

    return $shortcode_format;
}


function set_class_of_element($elem_class, $opts, $format) {
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


function set_style_of_element($width, $height, $opts, $format) {
    $style = '';

    if ( ! $opts['new_window_on'] ) {
        $style = ' style="height: ' . $height . 'px; max-width: ' . $width . 'px; width: 100%; border: 0;"';
    }

    $shortcode_format = str_replace('%style%', $style, $format);

    return $shortcode_format;
}


function set_additional_atts($tagname, $url, $height, $opts, $format) {
    $additional_atts = '';

    if ($tagname === 'a') {
        $additional_atts .= ' target="_blank"';
    }
    if ( ! $opts['is_mobile'] && $opts['new_window_on'] ) {
        $additional_atts .= ' onClick="javascript:window.open(\'' . $url . '\', ' 
            . '\'mailform1\', \'toolbar=no, location=no, status=yes, menubar=yes, resizable=yes, scrollbars=yes, '
            . 'width=600, height=' . $height . ', top=100, left=100\')"';
    }
    if ( $opts['thickbox_on'] ) {
        $additional_atts .= ' data-origin-height="' . $height . '"';
    }

    $shortcode_format = str_replace('%additional_atts%', $additional_atts, $format);

    return $shortcode_format;
}

