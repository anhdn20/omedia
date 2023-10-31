<?php
/**
 * The template for displaying the header
 *
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
 */

?>
<!DOCTYPE html>
<!-- Open HTML -->
<html <?php language_attributes(); ?>>
    <!-- Open Head -->
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
        <?php endif; ?>
        <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) : ?>
            <?php 
                $custom_favicon = haru_get_option('custom_favicon');
                if ( isset($custom_favicon) && !empty($custom_favicon['url']) ) : 
            ?>
                <link rel="shortcut icon" href="<?php echo esc_url(haru_get_option('custom_favicon')['url']); ?>" />
            <?php else : ?>
                <link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() . '/framework/admin-assets/images/theme-options/favicon.ico' ); ?>" />
            <?php endif; ?>
        <?php endif; ?>
        <?php wp_head(); ?>
    </head>
    <!-- Close Head -->
    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>
        <?php 
            /*
            *   @hooked - haru_site_preloader - 5;
            *   @hooked - haru_newsletter_popup - 10;
            */
            do_action( 'haru_before_page_main' );
        ?>
        <!-- Open haru main -->
        <div id="haru-main">
            <?php 
                /*
                *   @hooked - haru_page_top_bar - 5
                *   @hooked - haru_page_header - 10
                */
                do_action( 'haru_before_page_wrapper_content' );
            ?>
            <!-- Open HARU Content Main -->
            <div id="haru-content-main" class="clearfix">
            <?php 
                /*
                *   @hooked - haru_main_content start
                */
                do_action( 'haru_main_content_start' );
            ?>