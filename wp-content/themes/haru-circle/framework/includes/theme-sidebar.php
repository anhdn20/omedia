<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

 /*  Purpose: Register sidebar and add more custom sidebar via AJAX
 *   Files: theme-functions.php, haru-custom-sidebar.js, admin-style.css
 */

if ( !function_exists('haru_register_sidebar') ) {
    function haru_register_sidebar() {
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Sidebar 1','haru-circle' ),
                'id'            => 'sidebar-1',
                'description'   => esc_html__( 'Widget Area 1','haru-circle' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Sidebar 2','haru-circle' ),
                'id'            => 'sidebar-2',
                'description'   => esc_html__( 'Widget Area 2','haru-circle' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Sidebar Film Online','haru-circle' ),
                'id'            => 'sidebar-film',
                'description'   => esc_html__( 'Sidebar Film Online','haru-circle' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Top Bar Left','haru-circle' ),
                'id'            => 'top_bar_left',
                'description'   => esc_html__( 'Top Bar Left','haru-circle' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Top Bar Right','haru-circle' ),
                'id'            => 'top_bar_right',
                'description'   => esc_html__( 'Top Bar Right','haru-circle' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Woocommerce','haru-circle' ),
                'id'            => 'woocommerce',
                'description'   => esc_html__( 'Woocommerce Sidebar','haru-circle' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h4 class="widget-title"><span>',
                'after_title'   => '</span></h4>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Footer Gallery','haru-circle' ),
                'id'            => 'footer_gallery',
                'description'   => esc_html__( 'Display Footer Gallery','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Footer Tags','haru-circle' ),
                'id'            => 'footer_tags',
                'description'   => esc_html__( 'Display Product tags','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Mega Menu Column 1','haru-circle' ),
                'id'            => 'mega_menu_column_1',
                'description'   => esc_html__( 'Display Mega Menu widget','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Mega Menu Column 2','haru-circle' ),
                'id'            => 'mega_menu_column_2',
                'description'   => esc_html__( 'Display Mega Menu widget','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Mega Menu Tab 1','haru-circle' ),
                'id'            => 'mega_menu_tab_1',
                'description'   => esc_html__( 'Display Mega Menu widget','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Mega Menu Tab 2','haru-circle' ),
                'id'            => 'mega_menu_tab_2',
                'description'   => esc_html__( 'Display Mega Menu widget','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Mega Menu Tab 3','haru-circle' ),
                'id'            => 'mega_menu_tab_3',
                'description'   => esc_html__( 'Display Mega Menu widget','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );
        register_sidebar( 
            array(
                'name'          => esc_html__( 'Canvas Menu','haru-circle' ),
                'id'            => 'canvas-menu',
                'description'   => esc_html__( 'Display Canvas Menu widget','haru-circle' ),
                'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                'after_widget'  => '</section>',
                'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                'after_title'   => '</h3></div>',
            ) 
        );

        // Add custom sidebar using ajax
        $custom_sidebars = haru_get_custom_sidebars();
        if( is_array($custom_sidebars) && !empty($custom_sidebars) ) {
            foreach( $custom_sidebars as $name ) {
                $haru_custom_sidebars[] = array(
                    'name'          => ''.$name.'',
                    'id'            => sanitize_title($name),
                    'description'   => '',
                    'class'         => 'haru-custom-sidebar',
                    'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
                    'after_widget'  => '</section>',
                    'before_title'  => '<div class="widget-title-wrapper"><a class="block-control" href="javascript:void(0)"></a><h3 class="widget-title heading-title">',
                    'after_title'   => '</h3></div>',
                );
            }
            foreach( $haru_custom_sidebars as $custom_sidebar ) {
                register_sidebar($custom_sidebar);
            }
        }

    }

    add_action( 'widgets_init', 'haru_register_sidebar' );
}