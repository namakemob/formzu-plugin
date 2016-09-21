<?php

function get_iframe_height() {
    if ( ! check_ajax_referer('get_iframe_height', 'security', FALSE) ) {
        die('security error');
    }
    if ( ! isset($_POST['id']) ) {
        die('parameter error');
    }

    $id_num      = $_POST['id'];
    $form_page   = file_get_contents( 'https://ws.formzu.net/fgen/'  . $id_num . '/' );
    $mobile_page = file_get_contents( 'https://ws.formzu.net/sfgen/' . $id_num . '/' );

    die( json_encode(array($form_page, $mobile_page)) );
}

