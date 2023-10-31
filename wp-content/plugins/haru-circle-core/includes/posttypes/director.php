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

if ( ! class_exists( 'Haru_Circle_Director_Post_Type' ) ) {
    class Haru_Circle_Director_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_director';

            add_action('init', array($this,'haru_director'), '5'); // Must hook register post type and taxonomies with hight piority go make get_term() working
            add_action('admin_init', array($this, 'haru_register_meta_boxes'));

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tuharulus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_haru_director_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_director_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_director', 'normal' );
            remove_meta_box( 'handlediv', 'haru_director', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_director', 'normal' );
        }

        function haru_director() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Directors', 'haru-circle' ),
                'singular_name'      => esc_html__( 'Single Director', 'haru-circle' ),
                'name'               => esc_html__( 'Director', 'haru-circle' ),
                'add_new'            => esc_html__( 'Add New', 'haru-circle' ) ,
                'add_new_item'       => esc_html__( 'Add New Director', 'haru-circle' ) ,
                'edit_item'          => esc_html__( 'Edit Director', 'haru-circle' ) ,
                'new_item'           => esc_html__( 'Add New Director', 'haru-circle' ) ,
                'view_item'          => esc_html__( 'View Director', 'haru-circle' ) ,
                'search_items'       => esc_html__( 'Search Director', 'haru-circle' ) ,
                'not_found'          => esc_html__( 'No Director items found', 'haru-circle' ) ,
                'not_found_in_trash' => esc_html__( 'No Director items found in trash', 'haru-circle' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Director', 'haru-circle' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-businessman',
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
                    'slug'          => 'director',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_director', $args );

            // Register a taxonomy for Director Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Director Categories', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Director Category', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Director Categories', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Director Category', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Director Category', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Director Category', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Director Category', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Director Category Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Director Category', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Director Category:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Director Categories', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Director Categories', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Director Categories with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Director Categories', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Director Categories', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Director Categories found', 'haru-circle' ) ,
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
                    'slug'          => 'director-category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('director_category', array(
                'haru_director'
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
                    $terms = get_the_terms( $post_id, 'director_category' );
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
            //     'title'      => esc_html__( 'Director Metaboxes', 'haru-circle' ),
            //     'post_types' => array( 'haru_director' ),
            //     'tab'        => true,
            //     'fields'     => array(
            //         array(
            //             'id'      => $prefix . '_short_description',
            //             'name'    => esc_html__( 'Short Description', 'haru-circle' ),
            //             'type'    => 'textarea',
            //             'std'     => '',
            //         ),
            //         array(
            //             'id'               => $prefix.  '_gallery',
            //             'name'             => esc_html__( 'Images Gallery', 'haru-circle' ),
            //             'desc'             => esc_html__( 'Insert images for gallery.', 'haru-circle' ),
            //             'type'             => 'image_advanced',
            //         ),
            //         array(
            //             'id'                 => $prefix.  '_special',
            //             'name'               => esc_html__( 'Special', 'haru-circle' ),
            //             'desc'               => esc_html__( 'Director special Information.', 'haru-circle' ),
            //             'type'               => 'timeline',
            //             'datetime_holder'    => esc_html__( 'Datetime', 'haru-circle' ),
            //             'information_holder' => esc_html__( 'Information', 'haru-circle' ),
            //             'clone'              => true,
            //             // 'max_clone'          => 4,
            //             'sort_clone'         => true,
            //             'std'                => '',
            //         ),
            //         array(
            //             'id'             => $prefix.  '_social',
            //             'name'           => esc_html__( 'Social', 'haru-circle' ),
            //             'desc'           => esc_html__( 'Director Social Network Information. Max number of social networks set is 4.', 'haru-circle' ),
            //             'type'           => 'social',
            //             'network_holder' => esc_html__( 'Title (Ex: Facebook)', 'haru-circle' ),
            //             'url_holder'     => esc_html__( 'Url', 'haru-circle' ),
            //             'icon_holder'    => esc_html__( 'Icon class (Ex: fa fa-facebook)', 'haru-circle' ),
            //             'clone'          => true,
            //             'max_clone'      => 4,
            //             'sort_clone'     => true,
            //             'std'            => '',
            //         ),
            //     )
            // );

            // Use RW Metaboxies fields
            if ( class_exists('RW_Meta_Box') ) {
                foreach ($meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }

    new Haru_Circle_Director_Post_Type;
}