<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( !defined('ABSPATH') ) die('-1');

// include_once( plugin_dir_path(__FILE__) . 'metaboxes/spec.php' ); // Add new metabox

if ( ! class_exists( 'Haru_Circle_Video_Post_Type' ) ) {
    class Haru_Circle_Video_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_video';

            add_action('init', array($this,'haru_video'), '5'); // Must hook register post type and taxonomies with hight piority go make get_term() working
            // add_action('admin_init', array($this, 'haru_register_meta_boxes'));

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tuharulus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_haru_video_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_video_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_video', 'normal' );
            remove_meta_box( 'handlediv', 'haru_video', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_video', 'normal' );
        }

        function haru_video() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Videos', 'haru-circle' ),
                'singular_name'      => esc_html__( 'Single Video', 'haru-circle' ),
                'name'               => esc_html__( 'Video', 'haru-circle' ),
                'add_new'            => esc_html__( 'Add New', 'haru-circle' ) ,
                'add_new_item'       => esc_html__( 'Add New Video', 'haru-circle' ) ,
                'edit_item'          => esc_html__( 'Edit Video', 'haru-circle' ) ,
                'new_item'           => esc_html__( 'Add New Video', 'haru-circle' ) ,
                'view_item'          => esc_html__( 'View Video', 'haru-circle' ) ,
                'search_items'       => esc_html__( 'Search Video', 'haru-circle' ) ,
                'not_found'          => esc_html__( 'No Video items found', 'haru-circle' ) ,
                'not_found_in_trash' => esc_html__( 'No Video items found in trash', 'haru-circle' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Video', 'haru-circle' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-format-video',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail', 'comments' ),
                'rewrite'           => array(
                    'slug'          => 'video',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_video', $args );

            // Register a taxonomy for Video Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Video Categories', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Video Category', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Video Categories', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Video Category', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Video Category', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Video Category', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Video Category', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Video Category Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Video Category', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Video Category:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Video Categories', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Video Categories', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Video Categories with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Video Categories', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Video Categories', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Video Categories found', 'haru-circle' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'video-category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('video_category', array(
                'haru_video'
            ) , $category_args);
        }

        // Add columns to Team Members
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['post-format'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Title', 'haru-circle' )));
            $cols = array_merge($cols, array('category' => esc_html__( 'Category', 'haru-circle' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Thumbnail', 'haru-circle' )));
            $cols = array_merge($cols, array('date' => esc_html__( 'Date', 'haru-circle' )));

            return $cols;
        }

        // Set values for columns
        function set_columns_value($column, $post_id) {
            $prefix = $this->prefix;

            switch ($column) {
                case 'id': {
                    echo wp_kses_post($post_id);
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
                case 'category': {
                    $terms = get_the_terms( $post_id, 'video_category' );
                    if ( $terms && ! is_wp_error( $terms ) ) {
                        $term_links = array();
                        foreach($terms as $term) {
                            $term_links[] = $term->name;
                        }
                        echo join( ", ", $term_links );
                    }
                    break;
                }
            }
        }

        // Register metaboxies
        function haru_register_meta_boxes() {
            $prefix = $this->prefix;

            $meta_boxes   = array();
            // $meta_boxes[] = array(
            //     'id'         => $prefix . '_metabox',
            //     'title'      => esc_html__( 'Video Metaboxes', 'haru-circle' ),
            //     'post_types' => array( 'haru_video' ),
            //     'tab'        => true,
            //     'fields'     => array(
            //         array(
            //             'name'    => esc_html__( 'Source Server', 'haru-circle' ),
            //             'id'      => $prefix . '_server',
            //             'type'    => 'button_set',
            //             'options' => array(
            //                 'youtube' => esc_html__( 'Youtube','haru-circle' ),
            //                 'vimeo'   => esc_html__( 'Vimeo','haru-circle' ),
            //                 'url'     => esc_html__( 'Url','haru-circle' ),
            //             ),
            //             'std'      => 'youtube',
            //             'multiple' => false,
            //         ),
            //         array(
            //             'id'      => $prefix . '_id',
            //             'name'    => esc_html__( 'Video ID', 'haru-circle' ),
            //             'desc'    => esc_html__( 'Insert Video ID from Youtube or Vimeo server.', 'haru-circle' ),
            //             'type'    => 'text',
            //             'std'     => '',
            //             'visible' => array( $prefix . '_server', '!=', 'url' )
            //         ),
            //         array(
            //             'id'          => $prefix.  '_url',
            //             'name'        => esc_html__( 'Video Url', 'haru-circle' ),
            //             'desc'        => esc_html__( 'Insert Video Url from other server (mp4 and webm).', 'haru-circle' ),
            //             'mp4_holder'  => esc_html__( 'Mp4 Url', 'haru-circle' ),
            //             'webm_holder' => esc_html__( 'WebM Url', 'haru-circle' ),
            //             'type'        => 'video_url',
            //             'std'         => '',
            //             'visible'     => array( $prefix . '_server', '=', 'url' )
            //         ),
            //     )
            // );

            // Use RW Metaboxies fields
            // if ( class_exists('RW_Meta_Box') ) {
            //     foreach ($meta_boxes as $meta_box) {
            //         new RW_Meta_Box($meta_box);
            //     }
            // }
        }
    }

    new Haru_Circle_Video_Post_Type;
}