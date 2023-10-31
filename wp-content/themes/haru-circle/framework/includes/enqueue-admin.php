<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/* Register Font Admin */
if (!function_exists('haru_fonts_url_admin')) {
    function haru_fonts_url_admin() {
        $font_url = '';
        
        $lato = _x( 'on', 'Lato font: on or off', 'haru-circle' );
        $playfair = _x( 'on', 'Playfair Display font: on or off', 'haru-circle' );

        if ( 'off' !== $lato || 'off' !== $playfair ) {
            $font_families = array();
        }

        if ( 'off' !== $lato ) {
            $font_families[] = 'Lato:300,400,500,600,700,400italic';
        }

        if ( 'off' !== $playfair ) {
            $font_families[] = 'Playfair Display:400,700,400italic';
        }

        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

        return esc_url_raw( $fonts_url );
    }
}

if (!function_exists('haru_admin_enqueue_scripts')) {

    function haru_admin_enqueue_scripts() {
        // Enqueue Script
        wp_enqueue_script( 'haru-admin-js', get_template_directory_uri() . '/framework/admin-assets/js/haru-admin.js',array(), '1.0.0', true );
        wp_enqueue_script( 'haru-custom-sidebar', get_template_directory_uri() . '/framework/admin-assets/js/haru-custom-sidebar.js',array(), '1.0.0', true );

        if ( true == haru_check_rwm_status() ) { // Check metabox plugin load before load js for tab
            $meta_boxes  = haru_register_meta_boxes();
            $meta_box_id = '';
            foreach ($meta_boxes as $box) {
                if (!isset($box['tab'])) {
                    continue;
                }
                if (!empty($meta_box_id)) {
                    $meta_box_id .= ',';
                }
                $meta_box_id .= '#' . $box['id'];
            }

            wp_add_inline_script( 'haru-admin-js', 'var meta_box_ids = "' . $meta_box_id . '"', 'before' );
        }
        // Enqueue CSS
        wp_enqueue_style( 'haru-admin-style', get_template_directory_uri() . '/framework/admin-assets/css/admin-style.css', false, '1.0.0' );
        wp_enqueue_style( 'haru-admin-meta-box', get_template_directory_uri() . '/framework/admin-assets/css/metabox.css', false, '1.0.0' );
        wp_enqueue_style( 'haru-admin-redux', get_template_directory_uri() . '/framework/admin-assets/css/admin-redux.css', false, '1.0.0' );
        // Load font for editor
        wp_enqueue_style( 'haru-fonts-admin', haru_fonts_url_admin(), array(), '1.0.0' );
        /* Font-Awesome */
        $font_awesome_url = get_template_directory_uri() . '/assets/libraries/fonts-awesome/css/font-awesome.min.css';
        wp_enqueue_style( 'font-awesome', $font_awesome_url, array() );
        wp_enqueue_style( 'font-awesome-animation', get_template_directory_uri() . '/assets/libraries/fonts-awesome/css/font-awesome-animation.min.css', array() );
    }
    add_action( 'admin_enqueue_scripts', 'haru_admin_enqueue_scripts' );
}