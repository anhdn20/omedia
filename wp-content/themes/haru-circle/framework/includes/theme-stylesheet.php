<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com     
*/

if( !defined('HARU_DEVELOPE_MODE') && class_exists('scssc') && ('1' == haru_get_option('scss_compiler')) ) {
    add_action( 'redux/options/haru_circle_options/saved', 'haru_generate_scss' );
}

/* Generate scss to css */
function haru_theme_color_scss_variables() {
    // Process Color variables
    $primary_color = haru_get_option('primary_color');
    if ( isset($primary_color) && !empty($primary_color) ) {
        $primary_color = haru_get_option('primary_color');
    } else {
        $primary_color = '#fd6500';
    }

    $secondary_color = haru_get_option('secondary_color');
    if ( isset($secondary_color) && !empty($secondary_color) ) {
        $secondary_color = haru_get_option('secondary_color');
    } else {
        $secondary_color = '#fd6500';
    }

    $text_color = haru_get_option('text_color');
    if ( isset($text_color) && !empty($text_color) ) {
        $text_color = haru_get_option('text_color');
    } else {
        $text_color = '#696969';
    }

    $heading_color = haru_get_option('heading_color');
    if ( isset($heading_color) && !empty($heading_color) ) {
        $heading_color = haru_get_option('heading_color');
    } else {
        $heading_color = '#262626';
    }

    $link_color_attr = haru_get_option('link_color');
    if ( isset($link_color_attr) && !empty($link_color_attr) && !empty($link_color_attr['regular']) ) {
        $link_color = haru_get_option('link_color')['regular'];
    } else {
        $link_color         = '#696969';
    }
    if ( isset($link_color_attr) && !empty($link_color_attr) && !empty($link_color_attr['hover']) ) {
        $link_color_hover =  haru_get_option('link_color')['hover'];
    } else {
        $link_color_hover   = '#fd6500';
    }
    if ( isset($link_color_attr) && !empty($link_color_attr) && !empty($link_color_attr['active']) ) {
        $link_color_active = haru_get_option('link_color')['active'];
    } else {
        $link_color_active  = '#fd6500';
    }
    
    // Process typography
    // Body Font, Heading font and page title font processed in theme options - small of nubmer element use (output, compiler)
    $fonts = (object)array();

    // Body Font
    $body_font               = haru_get_option('body_font');
    if ( isset($body_font) && ! empty($body_font) && !empty($body_font['font-family']) ) {
        $fonts->body_font_family = haru_get_option('body_font')['font-family'];
        $fonts->body_font_weight = haru_get_option('body_font')['font-weight'];
        $fonts->body_font_size   = haru_get_option('body_font')['font-size'];
    } else {
        $fonts->body_font_family = 'Nunito Sans';
        $fonts->body_font_weight = '400';
        $fonts->body_font_size   = '14px';
    }

    // Secondary Font
    $secondary_font               = haru_get_option('secondary_font');
    if ( isset($secondary_font) && ! empty($secondary_font) && !empty($secondary_font['font-family']) ) {
        $fonts->secondary_font_family = haru_get_option('secondary_font')['font-family'];
        $fonts->secondary_font_weight = haru_get_option('secondary_font')['font-weight'];
        $fonts->secondary_font_size   = haru_get_option('secondary_font')['font-size'];
    } else {
        $fonts->secondary_font_family = 'Playfair Display';
        $fonts->secondary_font_weight = '400';
        $fonts->secondary_font_size   = '14px';
    }

    // Menu Font (can process in output option menu_font)
    $menu_font = haru_get_option('menu_font');
    if ( isset($menu_font) && ! empty($menu_font) && !empty($menu_font['font-family']) ) {
        $fonts->menu_font_family = haru_get_option('menu_font')['font-family'];
        $fonts->menu_font_weight = haru_get_option('menu_font')['font-weight'];
        $fonts->menu_font_size   = haru_get_option('menu_font')['font-size'];
    } else {
        $fonts->menu_font_family = 'Nunito Sans';
        $fonts->menu_font_weight = '700';
        $fonts->menu_font_size   = '14px';
    }

    // Scss variables to generate css
    $scss_variables                          = array();
    $scss_variables['primary_color']         = $primary_color;
    $scss_variables['secondary_color']       = $secondary_color;
    $scss_variables['text_color']            = $text_color;
    $scss_variables['heading_color']         = $heading_color;
    $scss_variables['link_color']            = $link_color;
    $scss_variables['link_color_hover']      = $link_color_hover;
    $scss_variables['link_color_active']     = $link_color_active;
    $scss_variables['body_font']             = $fonts->body_font_family;
    $scss_variables['body_font_weight']      = $fonts->body_font_weight;
    $scss_variables['body_font_size']        = $fonts->body_font_size;
    $scss_variables['secondary_font']        = $fonts->secondary_font_family;
    $scss_variables['secondary_font_weight'] = $fonts->secondary_font_weight;
    $scss_variables['secondary_font_size']   = $fonts->secondary_font_size;
    $scss_variables['menu_font']             = $fonts->menu_font_family;
    $scss_variables['menu_font_weight']      = $fonts->menu_font_weight;
    $scss_variables['menu_font_size']        = $fonts->menu_font_size;
    $scss_variables['theme_url']             = get_template_directory_uri();

    return $scss_variables;
}

function haru_theme_options_variables() {
    $custom_css           = '';
    $background_image_css = '';

    $body_background_mode = haru_get_option('body_background_mode');
    
    if ( $body_background_mode == 'background' ) {
        $body_background      = haru_get_option('body_background');
        $background_image_url = isset($body_background['background-image']) ? $body_background['background-image'] : '';
        $background_color     = isset($body_background['background-color']) ? $body_background['background-color'] : '';

        if ( !empty($background_color) ) {
            $background_image_css .= 'background-color:' . $background_color . ';';
        }

        if ( !empty($background_image_url) ) {
            $background_repeat     = isset($body_background['background-repeat']) ? $body_background['background-repeat'] : '';
            $background_position   = isset($body_background['background-position']) ? $body_background['background-position'] : '';
            $background_size       = isset($body_background['background-size']) ? $body_background['background-size'] : '';
            $background_attachment = isset($body_background['background-attachment']) ? $body_background['background-attachment'] : '';
            
            $background_image_css  .= 'background-image: url("'. $background_image_url .'");';

            if ( !empty($background_repeat) ) {
                $background_image_css .= 'background-repeat: '. $background_repeat .';';
            }

            if ( !empty($background_position) ) {
                $background_image_css .= 'background-position: '. $background_position .';';
            }

            if ( !empty($background_size) ) {
                $background_image_css .= 'background-size: '. $background_size .';';
            }

            if ( !empty($background_attachment) ) {
                $background_image_css .= 'background-attachment: '. $background_attachment .';';
            }
        }

    }

    if ( $body_background_mode == 'pattern' ) {
        $background_image_url =  get_theme_root_uri() . '/haru-circle/framework/admin-assets/images/theme-options/' . haru_get_option('body_background_pattern');
        $background_image_css .= 'background-image: url("'. $background_image_url .'");';
        $background_image_css .= 'background-repeat: repeat;';
        $background_image_css .= 'background-position: center center;';
        $background_image_css .= 'background-size: auto;';
        $background_image_css .= 'background-attachment: scroll;';
    }

    if ( !empty($background_image_css) ) {
        $custom_css .= 'body {' . $background_image_css . ' }';
    }

    // Site max width layout boxed
    $layout_site_max_width = haru_get_option('layout_site_max_width');
    $custom_css            .= 'body.layout-boxed #haru-main { max-width: ' . $layout_site_max_width . 'px; }';
    // Topbar fullwidth padding
    $top_bar_layout_padding = haru_get_option('top_bar_layout_padding');
    $top_bar_layout_padding = isset($top_bar_layout_padding) ? haru_get_option('top_bar_layout_padding') : '100';
    $custom_css            .= '.haru-top-bar .topbar-fullwith { padding-left:'. $top_bar_layout_padding .'px; padding-right: '. $top_bar_layout_padding .'px;}';
    
    $header_nav_layout_padding = haru_get_option('header_nav_layout_padding');
    $header_nav_layout_padding = isset($header_nav_layout_padding) ? haru_get_option('header_nav_layout_padding') : '100';
    $custom_css            .= '.haru-header-nav-wrapper .nav-fullwith { padding-left:'. $header_nav_layout_padding .'px; padding-right: '. $header_nav_layout_padding .'px;}';

    return $custom_css;
}

// Generate CSS when change in theme options
function haru_generate_scss() {
    try {
        $haru_options = get_option('haru_circle_options');
        if ( ! defined( 'FS_METHOD' ) ) {
            define('FS_METHOD', 'direct');
        }

        $style_dir  = get_theme_root();
        $style_uri  = get_theme_root_uri();
        
        $color_variables  = haru_theme_color_scss_variables();
        $option_variables = haru_theme_options_variables();

        // Create file .min.css (doesn't need .css file)
        $scss = new scssc();
        // Preset Variables
        $scss->setVariables( $color_variables );
        $scss->setImportPaths(get_template_directory() . '/assets/sass/');
        // Output Formatting: scss_formatter, scss_formatter_nested (default), scss_formatter_compressed
        $scss->setFormatter("scss_formatter_compressed");
        // Compile
        $css = $scss->compile('@import "style.scss";');
        $css .= $scss->compile($option_variables);

        require_once ABSPATH . 'wp-admin/includes/file.php';
        WP_Filesystem();
        global $wp_filesystem;

        if (!$wp_filesystem->put_contents( $style_dir . "/haru-circle/style-custom.min.css", $css, FS_CHMOD_FILE)) {
            return array(
                'status'  => 'error',
                'message' => esc_html__( 'Could not save file', 'haru-circle' )
            );
        }

    } catch(Exception $e) {
        $error_message = $e->getMessage();
        return array(
            'status'  => 'error',
            'message' => $error_message
        );
    }
}