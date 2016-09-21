<?php
/*
Plugin Name: Formzu Plugin
Plugin URI: http://www.formzu.com/
Description: Formzu Plugin
Version: 0.1.0
Author: Formzu
Author URI: http://www.formzu.com/
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


define( 'FORMZU_PLUGIN_PATH',        untrailingslashit(dirname(__FILE__)) );
define( 'FORMZU_PLUGIN_JS_PATH',     FORMZU_PLUGIN_PATH . '/js' );
define( 'FORMZU_PLUGIN_BASENAME',    plugin_basename(__FILE__ ) );

define( 'FORMZU_FORM_URL',    'https://ws.formzu.net/dist/' );

define( 'FORMZU_NAVMENU_NONCE',      'echo_formzu_link_navmenu_setting' );
define( 'FORMZU_NAVMENU_METABOX_ID', 'formzu-nav-metabox' );
define( 'FORMZU_NAVMENU_SELECT_ID',  'formzu-nav-select' );
define( 'FORMZU_NAVMENU_SUBMIT_ID',  'formzu-nav-submit' );


require_once FORMZU_PLUGIN_PATH . '/classes/action-hooks.php';
require_once FORMZU_PLUGIN_PATH . '/classes/file-loader.php';


register_activation_hook(__FILE__,   array('FormzuActionHooks', 'add_activation_actions'));
register_deactivation_hook(__FILE__, array('FormzuActionHooks', 'add_deactivation_actions'));


FormzuActionHooks::register_required_actions();

