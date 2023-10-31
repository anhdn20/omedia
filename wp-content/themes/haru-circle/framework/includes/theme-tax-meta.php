<?php
/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

// include the main class file
if ( is_admin() ) {
    /*
     * configure your meta box
     */
    $config = array(
        'id'             => 'category_meta_box',          // meta box id, unique per meta box
        'title'          => esc_html__( 'Category Meta Box', 'haru-circle' ) ,          // meta box title
        'pages'          => array('category','product_cat'),        // taxonomy name, accept categories, post_tag and custom taxonomies
        'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
        'fields'         => array(),            // list of meta fields (can be added by field arrays)
        'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );

    /*
     * Initiate your meta box
     */
    $my_meta =  new Tax_Meta_Class($config);

    /*
     * Add fields to your meta box
     */
    // Image field
    $my_meta->addImage( 'haru_' . 'page_title_background', array('name'=> esc_html__( 'Page Title Background', 'haru-circle') ) );

    /*
     * Don't Forget to Close up the meta box decleration
     */
    // Finish Meta Box Decleration
    $my_meta->Finish();

    // Add metabox for Film category
    $film_config = array(
        'id'             => 'category_meta_box',          // meta box id, unique per meta box
        'title'          => esc_html__( 'Category Meta Box', 'haru-circle' ) ,          // meta box title
        'pages'          => array('film_category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
        'context'        => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
        'fields'         => array(),            // list of meta fields (can be added by field arrays)
        'local_images'   => false,          // Use local or hosted images (meta box images for add/remove)
        'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
    );
    $film_meta =  new Tax_Meta_Class($film_config);
    $film_meta->addImage( 'haru_' . 'category_icon', array('name'=> esc_html__( 'Category Icon', 'haru-circle') ) );
    $film_meta->Finish();
}
