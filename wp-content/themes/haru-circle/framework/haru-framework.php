<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if( !function_exists( 'haru_framework' ) ) {
    function haru_framework() {
        // Load include libraries: theme_setup, theme_options,...
        if (file_exists( get_template_directory() . '/framework/includes/_init.php')) {
            require_once get_template_directory() . '/framework/includes/_init.php';
        }

        // Load core functions: theme redux framework, mega menu, ...
        if (file_exists( get_template_directory() . '/framework/core/_init.php')) {
            require_once get_template_directory() . '/framework/core/_init.php';
        }
        
        // Load metaboxes
        if ( true == haru_check_rwm_status() ) {
            require_once( WP_PLUGIN_DIR.'/meta-box/meta-box.php' );

            require_once get_template_directory() . '/framework/includes/theme-metabox.php'; // Add metaboxes for post, page,... Source: https://metabox.io/
            
            // Load metabox addons
            if ( true == haru_check_core_plugin_status() ) {
                if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/haru-meta-box-conditional-logic.php') ) {
                    require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/metabox-extensions/haru-meta-box-conditional-logic.php'; // Add logic extension for meta box
                }
            }
        }

        // Load theme tax meta (taxonomy metabox)
        if ( true == haru_check_core_plugin_status() ) {
            if ( file_exists( WP_PLUGIN_DIR.'/haru-circle-core/includes/libraries/tax-meta-class/tax-meta-class.php') ) {
                require_once WP_PLUGIN_DIR.'/haru-circle-core/includes/libraries/tax-meta-class/tax-meta-class.php';

                require_once( get_template_directory() . '/framework/includes/theme-tax-meta.php' ); // Add metabox for taxonomy, custom posttype,... Source: https://github.com/bainternet/My-Meta-Box/
            }
        }

        // Load VC extension
        if ( true == haru_check_vc_status() ) {
            require_once get_template_directory() . '/framework/vc_extension/_init.php';
        }
    }

    haru_framework();
}

// Check Visual Composer is active before load vc
function haru_check_vc_status() {
    include_once( ABSPATH.'wp-admin/includes/plugin.php' );
    if ( class_exists('Vc_Manager') ) {
        return true;
    } else {
        return false;
    }
}

// Check RW Metabox is active before load RWM
function haru_check_rwm_status() {
    include_once( ABSPATH.'wp-admin/includes/plugin.php' );
    if ( class_exists('RWMB_Loader') ) {
        return true;
    } else {
        return false;
    }
}

// Check Woocommerce is active before use Woocommerce in theme
function haru_check_woocommerce_status() {
    include_once( ABSPATH.'wp-admin/includes/plugin.php' );
    if ( class_exists('WooCommerce') ) {
        return true;
    } else {
        return false;
    }
}

// Check Haru Core plugin load
function haru_check_core_plugin_status() {
    include_once( ABSPATH.'wp-admin/includes/plugin.php' );
    if ( class_exists('Haru_CircleCore') ) {
        return true;
    } else {
        return false;
    }
}