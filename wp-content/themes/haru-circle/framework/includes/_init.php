<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/


// Include Redux theme options
if( !function_exists( 'haru_include_theme_options' ) && class_exists( 'ReduxFramework' ) ) {
    function haru_include_theme_options() {
        // Use this to override Redux Framework
        if (file_exists( get_template_directory().'/framework/core/haru_reduxframework.php')) {
            require_once get_template_directory() . '/framework/core/haru_reduxframework.php';
        }

        // Load the theme/plugin options
        if ( file_exists( get_template_directory() . '/framework/includes/theme-options.php' ) ) {
            require_once get_template_directory() . '/framework/includes/theme-options.php';
        }
    }
    
    haru_include_theme_options();
}

// Include core files
if( !function_exists( 'haru_include_core_files' ) ) {
    function haru_include_core_files() {
        require_once( get_template_directory() . '/framework/includes/tgmpa-register.php' ); // Required plugins for theme
        require_once( get_template_directory() . '/framework/includes/theme-setup.php' ); // Declare theme_support(), load_theme_textdomain(),...
        require_once( get_template_directory() . '/framework/includes/theme-functions.php' ); // Include functions as add custom sidebar, ...
        require_once( get_template_directory() . '/framework/includes/theme-hooks.php' ); // Include theme hooks

        if ( true == haru_check_woocommerce_status() ) {
            require_once( get_template_directory() . '/framework/includes/woocommerce-functions.php' ); // Include woocommerce functions ...
            require_once( get_template_directory() . '/framework/includes/woocommerce-hooks.php' ); // Include woocommerce hooks
        }

        require_once( get_template_directory() . '/framework/includes/theme-sidebar.php' ); // Add sidebar and custom sidebar for theme
        require_once( get_template_directory() . '/framework/includes/enqueue-admin.php' ); // Add assets for back-end
        require_once( get_template_directory() . '/framework/includes/enqueue-frontend.php' ); // Load assets for front-end

        // Compile theme stylesheet
        require_once( get_template_directory() . '/framework/includes/theme-stylesheet.php' );
    }

    haru_include_core_files();
}