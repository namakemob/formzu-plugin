<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

class FormzuNavMenuItemFields
{
    private function __construct()
    {
    }

    static $options = array();

    static function setup()
    {
        self::$options['fields'] = array(
            'form_id' => 'form_id',
        );

        add_action('save_post', array(__CLASS__, '_save_post'));
    }

    static function get_fields_schema()
    {
        $schema = array();

        foreach (self::$options['fields'] as $name => $field) {
            $schema[] = $field;
        }
        return $schema;
    }

    static function get_menu_item_postmeta_key($name)
    {
        return '_menu_item_' . $name;
    }

    static function _add_fields($new_fields, $item_output, $item, $depth, $args)
    {
        $schema = self::get_fields_schema($item->ID);

        foreach ($schema as $field) {

            $field['value'] = get_post_meta($item->ID, self::get_menu_item_postmeta_key($field['name']), true);

            $new_fields .= str_replace(
                array_map(function($key){ return '{' . $key . '}'; }, array_keys($field)),
                array_values(array_map('esc_attr', $field)),
                self::$options['item']
            );

        }
        return $new_fields;
    }

    static function _save_post($post_id)
    {
        if (get_post_type($post_id) !== 'nav_menu_item') {
            return;
        }

        if ( ! isset($_POST['menu-item-url'][$post_id]) ) {
            return;
        }

        $url = $_POST['menu-item-url'][$post_id];

        if (strlen(strval($url)) > 10) {
            return;
        }

        if ( isset($_POST['menu-item-object'][$post_id]) && $_POST['menu-item-object'][$post_id] == 'post_type_formzu_link' ) {

            $url = stripslashes($url);

            update_post_meta($post_id, '_menu_item_url',    $url);
            update_post_meta($post_id, '_menu_item_type',   'formzu_link');
            update_post_meta($post_id, '_menu_item_object', 'post_type_formzu_link');           
        }
    }
}

