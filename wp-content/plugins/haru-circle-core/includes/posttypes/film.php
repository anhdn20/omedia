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

if ( ! class_exists( 'Haru_Circle_Film_Post_Type' ) ) {
    class Haru_Circle_Film_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_film';

            add_action('init', array($this,'haru_film'), '5'); // Must hook register post type and taxonomies with hight piority go make get_term() working
            add_action('admin_init', array($this, 'haru_register_meta_boxes'));

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tuharulus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_haru_film_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_film_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_film', 'normal' );
            remove_meta_box( 'handlediv', 'haru_film', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_film', 'normal' );
        }

        function haru_film() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Films', 'haru-circle' ),
                'singular_name'      => esc_html__( 'Single Film', 'haru-circle' ),
                'name'               => esc_html__( 'Film', 'haru-circle' ),
                'add_new'            => esc_html__( 'Add New', 'haru-circle' ),
                'add_new_item'       => esc_html__( 'Add New Film', 'haru-circle' ),
                'edit_item'          => esc_html__( 'Edit Film', 'haru-circle' ),
                'new_item'           => esc_html__( 'Add New Film', 'haru-circle' ),
                'view_item'          => esc_html__( 'View Film', 'haru-circle' ),
                'search_items'       => esc_html__( 'Search Film', 'haru-circle' ),
                'not_found'          => esc_html__( 'No Film items found', 'haru-circle' ),
                'not_found_in_trash' => esc_html__( 'No Film items found in trash', 'haru-circle' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display Film', 'haru-circle' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-video-alt2',
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
                    'slug'          => 'film',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_film', $args );

            // Register a taxonomy for Film Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Film Categories', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Film Category', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Film Categories', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Film Category', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Film Category', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Film Category', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Film Category', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Film Category Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Film Category', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Film Category:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Film Categories', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Film Categories', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Film Categories with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Film Categories', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Film Categories', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Film Categories found', 'haru-circle' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'film-category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('film_category', array(
                'haru_film'
            ) , $category_args);

            // Register a taxonomy for Film Tags.
            $tag_labels = array(
                'name'                          => esc_html__( 'Film Tags', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Film Tag', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Tags', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Film Tags', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Film Tag', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Film Tag', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Film Tag', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Film Tag', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Film Tag Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Film Tag', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Film Tag:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Film Tags', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Film Tags', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Film Tags with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Film Tags', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Film Tags', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Film Tags found', 'haru-circle' ) ,
            );

            $tag_args = array(
                'labels'            => $tag_labels,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => false, // important
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'film-tag',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('film_tag', array(
                'haru_film'
            ) , $tag_args);

            // Register a taxonomy for Film Country.
            $country_labels = array(
                'name'                          => esc_html__( 'Film Countries', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Film Country', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Countries', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Film Countries', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Film Country', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Film Country', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Film Country', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Film Country', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Film Country Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Film Country', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Film Country:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Film Countries', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Film Countries', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Film Countries with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Film Countries', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Film Countries', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Film Countries found', 'haru-circle' ) ,
            );

            $country_args = array(
                'labels'            => $country_labels,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'country',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('film_country', array(
                'haru_film'
            ) , $country_args);

            // Register a taxonomy for Film Year.
            $year_labels = array(
                'name'                          => esc_html__( 'Film Year', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Film Year', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Year', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Film Year', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Film Year', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Film Year', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Film Year', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Film Year', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Film Year Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Film Year', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Film Year:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Film Year', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Film Year', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Film Year with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Film Year', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Film Year', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Film Year found', 'haru-circle' ) ,
            );

            $year_args = array(
                'labels'            => $year_labels,
                'public'            => true,
                'show_ui'           => true,
                'show_in_nav_menus' => true,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'year',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('film_year', array(
                'haru_film'
            ) , $year_args);
        }

        // Add columns to Film
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
                    $terms = get_the_terms( $post_id, 'film_category' );
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
            //     'title'      => esc_html__( 'Film Metaboxes', 'haru-circle' ),
            //     'post_types' => array( 'haru_film' ),
            //     'tab'        => true,
            //     'fields'     => array(
            //         array(
            //             'id'      => $prefix . '_short_description',
            //             'name'    => esc_html__( 'Short Description', 'haru-circle' ),
            //             'type'    => 'textarea',
            //             'std'     => '',
            //         ),
            //         array(
            //             'id'          => $prefix . '_director',
            //             'name'        => esc_html__( 'Director', 'haru-circle' ),
            //             'desc'        => esc_html__( 'Director of Film.', 'haru-circle' ),
            //             'type'        => 'post',
            //             // Post type
            //             'post_type'   => 'haru_director',
            //             // Field type, either 'select' or 'select_advanced' (default)
            //             'field_type'  => 'select_advanced',
            //             'placeholder' => esc_html__( 'Select Director', 'haru-circle' ),
            //             // Query arguments (optional). No settings means get all published posts
            //             'multiple'    => false,
            //             'query_args'  => array(
            //                 'post_status'    => 'publish',
            //                 'posts_per_page' => - 1,
            //             ),
            //         ),
            //         array(
            //             'id'          => $prefix . '_actor',
            //             'name'        => esc_html__( 'Actor', 'haru-circle' ),
            //             'desc'        => esc_html__( 'Actor of Film.', 'haru-circle' ),
            //             'type'        => 'post',
            //             // Post type
            //             'post_type'   => 'haru_actor',
            //             // Field type, either 'select' or 'select_advanced' (default)
            //             'field_type'  => 'select_advanced',
            //             'placeholder' => esc_html__( 'Select Actors', 'haru-circle' ),
            //             // Query arguments (optional). No settings means get all published posts
            //             'multiple'    => true,
            //             'query_args'  => array(
            //                 'post_status'    => 'publish',
            //                 'posts_per_page' => - 1,
            //             ),
            //         ),
            //         array(
            //             'name'    => esc_html__( 'Film Type', 'haru-circle' ),
            //             'id'      => $prefix . '_type',
            //             'type'    => 'button_set',
            //             'options' => array(
            //                 'short'  => esc_html__( 'Short','haru-circle' ),
            //                 'series' => esc_html__( 'Series','haru-circle' ),
            //             ),
            //             'std'      => 'short',
            //             'multiple' => false,
            //         ),
            //         array(
            //             'id'      => $prefix.  '_episode_number',
            //             'name'    => esc_html__( 'Episodes Number', 'haru-circle' ),
            //             'desc'    => esc_html__( 'Number of Film\'s episodes.', 'haru-circle' ),
            //             'type'    => 'number',
            //             'std'     => '10',
            //             'visible' => array( $prefix . 'film_type', '=', 'series' )
            //         ),
            //         array(
            //             'id'   => $prefix.  '_duration',
            //             'name' => esc_html__( 'Film duration', 'haru-circle' ),
            //             'desc' => esc_html__( 'Duration of one Film\'s episodes (minutes).', 'haru-circle' ),
            //             'type' => 'number',
            //             'std'  => '90',
            //         ),
            //         array(
            //             'id'   => $prefix.  '_trailer',
            //             'name'        => esc_html__( 'Film trailer', 'haru-circle' ),
            //             'desc'        => esc_html__( 'Trailer of Film.', 'haru-circle' ),
            //             'type'        => 'post',
            //             // Post type
            //             'post_type'   => 'haru_trailer',
            //             // Field type, either 'select' or 'select_advanced' (default)
            //             'field_type'  => 'select_advanced',
            //             'placeholder' => esc_html__( 'Select Trailer', 'haru-circle' ),
            //             // Query arguments (optional). No settings means get all published posts
            //             'multiple'    => false,
            //             'query_args'  => array(
            //                 'post_status'    => 'publish',
            //                 'posts_per_page' => - 1,
            //             ),
            //         ),
            //     )
            // );
            
            // Videos
            // $meta_boxes[] = array(
            //     'id'         => $prefix . '_metabox_videos',
            //     'title'      => esc_html__( 'Videos', 'haru-circle' ),
            //     'post_types' => array( 'haru_film' ),
            //     'tab'        => true,
            //     'fields'     => array(
            //         array(
            //             'id'                => $prefix. '_videos',
            //             'name'              => esc_html__( 'Videos', 'haru-circle' ),
            //             'desc'              => esc_html__( 'Set videos of Film.', 'haru-circle' ),
            //             'type'              => 'videos',
            //             'title_holder'      => esc_html__( 'Video Name', 'haru-circle' ),
            //             'youtube_holder'    => esc_html__( 'Youtube Server', 'haru-circle' ),
            //             'vimeo_holder'      => esc_html__( 'Vimeo Server', 'haru-circle' ),
            //             'local_holder'      => esc_html__( 'Local Server', 'haru-circle' ),
            //             'youtube_id_holder' => esc_html__( 'Youtube ID', 'haru-circle' ),
            //             'vimeo_id_holder'   => esc_html__( 'Vimeo ID', 'haru-circle' ),
            //             'mp4_holder'        => esc_html__( 'Mp4 Url', 'haru-circle' ),
            //             'webm_holder'       => esc_html__( 'WebM Url', 'haru-circle' ),
            //             'clone'             => true,
            //             // 'max_clone'      => 4,
            //             'sort_clone'        => true,
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

    new Haru_Circle_Film_Post_Type;
}