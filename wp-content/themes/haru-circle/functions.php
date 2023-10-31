<?php 
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// Load the HARU theme framework, all functions for theme will in includes folder in framework folder
require get_template_directory()  . '/framework/haru-framework.php';

// Remove plugin flag from redux. Get rid of redirect
add_action( 'redux/construct', 'haru_remove_as_plugin_flag' );

function haru_remove_as_plugin_flag() {
    ReduxFramework::$_as_plugin = false;
}


// Disable revslider notice.
if ( function_exists( 'rev_slider_shortcode' ) ) {
    add_action( 'admin_init', 'haru_disable_revslider_notice' );
}

function haru_disable_revslider_notice() {
    update_option( 'revslider-valid-notice', 'false' );
}