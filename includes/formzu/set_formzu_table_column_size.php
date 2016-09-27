<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function set_formzu_table_column_size() {
    echo '<style type="text/css">';
    echo '.wp-list-table .column-cb { width: 3%; }';
    echo '.wp-list-table .column-number { width: 5%; }';
    echo '.wp-list-table .column-name { width: 24%; }';
    echo '.wp-list-table .column-pagebutton { width: 14%; }';
    echo '.wp-list-table .column-widgetbutton { width: 14%; }';
    echo '.wp-list-table .column-shortcode { width: 15%; }';
    echo '.wp-list-table .column-items { width: 25%; }';
    echo '</style>';
}

