<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( !class_exists( 'Haru_Testimonial_Post_Type' ) ) {
    class Haru_Testimonial_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_testimonial';

            add_action('init', array($this,'haru_testimonial'));
            add_action('admin_init', array($this, 'haru_register_meta_boxes'));

            if( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tuharulus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_haru_testimonial_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_testimonial_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_testimonial', 'normal' );
            remove_meta_box( 'handlediv', 'haru_testimonial', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_testimonial', 'normal' );
        }

        function haru_testimonial() {
            $labels = array(
                'name'               => esc_html__( 'Testimonials', 'haru-circle' ),
                'singular_name'      => esc_html__( 'Testimonial', 'haru-circle' ),
                'menu_name'          => esc_html__( 'Testimonials', 'haru-circle' ),
                'add_new'            => esc_html__( 'Add New', 'haru-circle' ) ,
                'add_new_item'       => esc_html__( 'Add New Testimonial', 'haru-circle' ) ,
                'edit_item'          => esc_html__( 'Edit Testimonial', 'haru-circle' ) ,
                'new_item'           => esc_html__( 'Add New Testimonial', 'haru-circle' ) ,
                'view_item'          => esc_html__( 'View Testimonial', 'haru-circle' ) ,
                'search_items'       => esc_html__( 'Search Testimonial', 'haru-circle' ) ,
                'not_found'          => esc_html__( 'No Testimonial items found', 'haru-circle' ) ,
                'not_found_in_trash' => esc_html__( 'No Testimonial items found in trash', 'haru-circle' ) ,
                'parent_item_colon'  => '',
                'rewrite'           => array(
                    'slug'          => 'testimonial',
                    'with_front'    => false
                ) ,
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display client\'s testimonials', 'haru-circle' ),
                'supports'              => array( 'title', 'editor', 'thumbnail' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-id',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
            );

            register_post_type( 'haru_testimonial', $args );

            // Register a taxonomy for Testimonials Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Testimonial Categories', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Testimonial Category', 'haru-circle') ,
                'menu_name'                     => esc_html__( 'Categories', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Testimonial Categories', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Testimonial Category', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Testimonial Category', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Testimonial Category', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Testimonial Category', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Testimonial Category Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Testimonial Category', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Testimonial Category:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Testimonial Categories', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Testimonial Categories', 'haru-circle') ,
                'separate_items_with_commas'    => esc_html__( 'Separate Testimonial Categories with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Testimonial Categories', 'haru-circle' ) ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Testimonial Categories', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Testimonial Categories found', 'haru-circle' ) ,
            );

            $category_args = array(
                'labels'            => $category_labels,
                'public'            => false,
                'show_ui'           => true,
                'show_in_nav_menus' => false,
                'show_tagcloud'     => false,
                'show_admin_column' => false,
                'hierarchical'      => true,
                'query_var'         => true,
                'rewrite'           => array(
                    'slug'          => 'category',
                    'with_front'    => false
                ) ,
            );

            register_taxonomy('testimonial_category', array(
                'haru_testimonial'
            ) , $category_args);
        }

        // Add columns to Testimonial
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Name', 'haru-circle' )));
            $cols = array_merge($cols, array('email' => esc_html__( 'Email', 'haru-circle' )));
            $cols = array_merge($cols, array('thumbnail' => esc_html__( 'Picture', 'haru-circle' )));
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
                case 'email': {
                    echo get_post_meta($post_id, "{$prefix}_email", true);
                    break;
                }
                case 'thumbnail': {
                    echo get_the_post_thumbnail($post_id, 'thumbnail');
                    break;
                }
            }
        }

        // Register metaboxies
        function haru_register_meta_boxes() {
            $prefix       = $this->prefix;

            $meta_boxes   = array();
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_boxes",
                'title'         => esc_html__( 'Testimonial Information:', 'haru-circle' ),
                'post_types'    => array( 'haru_testimonial' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_position",
                        'name'  => esc_html__( 'Position', 'haru-circle' ),
                        'type'  => 'text',
                    ),
                )
            );
            
            // Use RW Metaboxies fields
            if ( class_exists('RW_Meta_Box') ) {
                foreach ($meta_boxes as $meta_box) {
                    new RW_Meta_Box($meta_box);
                }
            }
        }
    }

    new Haru_Testimonial_Post_Type;
}