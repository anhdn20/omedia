<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

/* Load theme css */
if (!function_exists('haru_enqueue_styles')) {
    function haru_enqueue_styles() {
        /* Bootstrap CSS */
        $url_bootstrap = get_template_directory_uri() . '/assets/libraries/bootstrap/css/bootstrap.min.css';
        wp_enqueue_style( 'bootstrap', $url_bootstrap, array() );

        /* Font-awesome */
        $url_font_awesome = get_template_directory_uri() . '/assets/libraries/fonts-awesome/css/font-awesome.min.css';
        wp_enqueue_style( 'font-awesome', $url_font_awesome, array());
        wp_enqueue_style( 'font-awesome-animation', get_template_directory_uri() . '/assets/libraries/fonts-awesome/css/font-awesome-animation.min.css', array() );

        /* Font-ionicons */
        $url_font_ionicons = get_template_directory_uri() . '/assets/libraries/ionicons/css/ionicons.min.css';
        wp_enqueue_style( 'font-ionicons', $url_font_ionicons, array());

        $url_font_themify = get_template_directory_uri() . '/assets/libraries/themify/themify-icons.css';
        wp_enqueue_style( 'themify', $url_font_themify, array());

        /* jPlayer */ 
        wp_enqueue_style( 'jplayer', get_template_directory_uri() . '/assets/libraries/jPlayer/skin/haru/skin.css', array() );

        /* owl-carousel */ 
        wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/assets/owl.carousel.min.css', array() );

        /* slick */ 
        wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.css', array() );

        /* prettyPhoto */ 
        wp_enqueue_style( 'prettyPhoto', get_template_directory_uri() . '/assets/libraries/prettyPhoto/css/prettyPhoto.min.css', array() );

        /* magnificPopup */ 
        wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/libraries/magnificPopup/magnific-popup.css', array() );

        /* Mega Menu */ 
        wp_register_style( 'megamenu-animate', get_template_directory_uri() . '/framework/core/megamenu/assets/css/animate.css' );
        wp_enqueue_style( 'megamenu-animate' );

        /* VC Customize */ 
        wp_enqueue_style( 'haru-vc-customize', get_template_directory_uri() . '/assets/css/vc-customize.css' );

        // Load Theme CSS custom
        $style_dir  = get_theme_root();
        $style_uri  = get_theme_root_uri();

        if ( file_exists( $style_dir . '/haru-circle/style-custom.min.css' ) && !defined('HARU_DEVELOPE_MODE') ) {
            wp_enqueue_style( 'haru-theme-style', $style_uri . '/haru-circle/style-custom.min.css', array(), filemtime( $style_dir . '/haru-circle/style-custom.min.css' ) );
        } else {
            /* Theme CSS */
            wp_enqueue_style( 'haru-theme-style', get_template_directory_uri() . '/style.css' );
        }

        // Load default font
        if ( !class_exists('ReduxFramework') ) {
            wp_enqueue_style( 'haru-theme-font', 'http://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900,200italic,300italic,400italic,600italic,700italic,800italic,900italic%7CPlayfair+Display+SC:400,700,900,400italic,700italic,900italic%7CPlayfair+Display:400,700,900,400italic,700italic,900italic%7CUbuntu:300,400,500,700,300italic,400italic,500italic,700italic' );
        } 
    }

    add_action('wp_enqueue_scripts', 'haru_enqueue_styles', 11);
    add_action('wp_enqueue_scripts', 'haru_enqueue_custom_css', 12); // Add Theme Options custom CSS after theme-style enqueued
}

/* Load theme js */
if (!function_exists('haru_enqueue_script')) {
    function haru_enqueue_script() {
        /* Bootstrap JS */
        $url_bootstrap = get_template_directory_uri() . '/assets/libraries/bootstrap/js/bootstrap.min.js';
        wp_enqueue_script('bootstrap', $url_bootstrap, array('jquery'), false, true);

        /* Comments */
        if (is_single()) {
            wp_enqueue_script('comment-reply');
        }

        /* jPlayer */ 
        wp_enqueue_script( 'jplayer', get_template_directory_uri() . '/assets/libraries/jPlayer/jquery.jplayer.min.js', array( 'jquery' ), '', true );

        /* owl-carousel */ 
        wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/libraries/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '', true );

        /* slick */ 
        wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/libraries/slick/slick.min.js', array( 'jquery' ), '', true );

        /* prettyPhoto */ 
        wp_enqueue_script( 'prettyPhoto', get_template_directory_uri() . '/assets/libraries/prettyPhoto/js/jquery.prettyPhoto.min.js', array( 'jquery' ), '', true );

        /* imagesloaded */ 
        wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/assets/libraries/imagesloaded/imagesloaded.min.js', array( 'jquery' ), '', true );

        /* infinite scroll */ 
        wp_enqueue_script( 'infinitescroll', get_template_directory_uri() . '/assets/libraries/infinitescroll/jquery.infinitescroll.min.js', array( 'jquery' ), '', true );

        /* isotope */ 
        wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/libraries/isotope/isotope.pkgd.min.js', array( 'jquery' ), '', true );

        /* stellar */ 
        wp_enqueue_script( 'stellar', get_template_directory_uri() . '/assets/libraries/stellar/jquery.stellar.min.js', array( 'jquery' ), '', true );

        /* Cookie and Magfinic popup */
        wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/libraries/modernizr/modernizr.js', array(), false, true);
        wp_enqueue_script( 'jquery-cookie', get_template_directory_uri() . '/assets/libraries/cookie/jquery.cookie.js', array(), false, true);
        wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/libraries/magnificPopup/jquery.magnific-popup.min.js', array(), false, true);

        /* Load sticky plugin */
        wp_enqueue_script( 'haru-sticky-plugin', get_template_directory_uri() . '/assets/libraries/sticky/haru-sticky-plugin.min.js', array(), false, true) ;

        /* Mega Menu */
        wp_register_script( 'megamenu-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/megamenu.js', array(), false, true );
        wp_enqueue_script( 'megamenu-js' );

        /* Load theme main js */
        wp_enqueue_script( 'haru-theme-script', get_template_directory_uri() . '/assets/js/haru-main.js', array( 'jquery' ), false, true );

        wp_enqueue_script( 'haru-shop', get_template_directory_uri() . '/assets/js/haru-shop.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'haru-shop-ajax', get_template_directory_uri() . '/assets/js/haru-shop-ajax.min.js', array( 'jquery' ), false, true );

        /* Load circle js */
        wp_enqueue_script( 'haru-circle-script', get_template_directory_uri() . '/assets/js/haru-circle.js', array( 'jquery' ), false, true );

       wp_add_inline_script( 'haru-theme-script', 'var haru_framework_ajax_url = "' . get_site_url() . '/wp-admin/admin-ajax.php?activate-multi=true' . '"', 'before' );

        /* Localize the script (constants) */
        $translation_array = array(
            'product_compare'  => esc_html__( 'Compare', 'haru-circle' ), // Add translate css tooltip for compare button
            'product_viewcart' => esc_html__( 'View Cart', 'haru-circle' ), // Add translate css tooltip for view cart button
        );
        wp_add_inline_script( 'haru-theme-script', 'var haru_framework_constant = ' . json_encode( $translation_array ), 'before' );
        wp_add_inline_script( 'haru-theme-script', 'var haru_framework_theme_url = "' . get_template_directory_uri() . '"', 'before' );
    }
    add_action('wp_enqueue_scripts', 'haru_enqueue_script');
    add_action('wp_enqueue_scripts', 'haru_enqueue_custom_script', 15);
}

/* Enqueue admin */ 
// Load enqueue script Haru Mega Menu
add_action( 'admin_enqueue_scripts', 'haru_mega_menu_enqueue_script_admin' ); // back-end
if ( !function_exists('haru_mega_menu_enqueue_script_admin') ) {
    function haru_mega_menu_enqueue_script_admin( $hook ) {

        if ( $hook != 'nav-menus.php' ) {
            return;
        }
        // Enqueue style for Mega Menu admin
        wp_register_style( 'megamenu-admin', get_template_directory_uri() . '/framework/core/megamenu/assets/css/megamenu-admin.css' );
        wp_enqueue_style( 'megamenu-admin' );

        // Load color picker library
        wp_enqueue_style( 'wp-color-picker' );
        wp_register_script( 'megamenu-admin-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/megamenu-admin.js', array( 'wp-color-picker' ), false, true );
        wp_enqueue_script( 'megamenu-admin-js' );

        // Use this for select image from library
        wp_register_script( 'megamenu-media-init-js', get_template_directory_uri() . '/framework/core/megamenu/assets/js/media-init.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'megamenu-media-init-js' );

        wp_register_style( 'fontawesome', get_template_directory_uri() . '/assets/libraries/fonts-awesome/css/font-awesome.min.css' );
        wp_enqueue_style( 'fontawesome' );
    }
}

/* Load theme options custom css */
if ( !function_exists('haru_enqueue_custom_css') ) {
    function haru_enqueue_custom_css() {
        $custom_css = haru_get_option('custom_css');

        wp_add_inline_style( 'haru-theme-style', $custom_css );
    }
}

/* Load theme options custom js */
if( !function_exists('haru_enqueue_custom_script') ) {
    function haru_enqueue_custom_script() {
        $custom_js = haru_get_option('custom_js');

        wp_add_inline_script( 'haru-theme-script', $custom_js );
    }
}