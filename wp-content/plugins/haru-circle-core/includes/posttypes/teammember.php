<?php
/**
 * @package    HaruTheme/Haru Circle
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright (c) 2017, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

if ( ! class_exists( 'Haru_Teammember_Post_Type' ) ) {
    class Haru_Teammember_Post_Type {

        protected $prefix;

        public function __construct() {
            $this->prefix = 'haru_teammember';

            add_action('init', array($this,'haru_teammember'));
            add_action('admin_init', array($this, 'haru_register_meta_boxes'));

            if ( is_admin() ) {
                add_action( 'do_meta_boxes', array( $this, 'remove_plugin_metaboxes' ) );
                // Add custom columns reference: http://code.tuharulus.com/articles/add-a-custom-column-in-posts-and-custom-post-types-admin-screen--wp-24934
                add_filter( 'manage_haru_teammember_posts_columns', array( $this, 'add_columns' ) );
                add_action( 'manage_haru_teammember_posts_custom_column', array( $this, 'set_columns_value'), 10, 2);
            }
        }

        function remove_plugin_metaboxes() {
            remove_meta_box( 'mymetabox_revslider_0', 'haru_teammember', 'normal' );
            remove_meta_box( 'handlediv', 'haru_teammember', 'normal' );
            remove_meta_box( 'commentsdiv', 'haru_teammember', 'normal' );
        }

        function haru_teammember() {
            $prefix = $this->prefix;

            $labels = array(
                'menu_name'          => esc_html__( 'Team Members', 'haru-circle' ),
                'singular_name'      => esc_html__( 'Team Member', 'haru-circle' ),
                'name'               => esc_html__( 'Team Members', 'haru-circle' ),
                'add_new'            => esc_html__( 'Add New', 'haru-circle' ) ,
                'add_new_item'       => esc_html__( 'Add New Team Member', 'haru-circle' ) ,
                'edit_item'          => esc_html__( 'Edit Team Member', 'haru-circle' ) ,
                'new_item'           => esc_html__( 'Add New Team Member', 'haru-circle' ) ,
                'view_item'          => esc_html__( 'View Team Member', 'haru-circle' ) ,
                'search_items'       => esc_html__( 'Search Team Member', 'haru-circle' ) ,
                'not_found'          => esc_html__( 'No Team Member items found', 'haru-circle' ) ,
                'not_found_in_trash' => esc_html__( 'No Team Member items found in trash', 'haru-circle' ) ,
                'parent_item_colon'  => ''
            );

            $args = array(
                'labels'                => $labels,
                'description'           => esc_html__( 'Display members of team work', 'haru-circle' ),
                'hierarchical'          => false,
                'public'                => false,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-groups',
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => false,
                'capability_type'       => 'post',
                'supports'              => array( 'title', 'editor', 'thumbnail'),
                'rewrite'           => array(
                    'slug'          => 'teammember',
                    'with_front'    => false
                ) ,
            );
            register_post_type( 'haru_teammember', $args );

            // Register a taxonomy for Team Categories.
            $category_labels = array(
                'name'                          => esc_html__( 'Team Categories', 'haru-circle' ) ,
                'singular_name'                 => esc_html__( 'Team Category', 'haru-circle' ) ,
                'menu_name'                     => esc_html__( 'Team Categories', 'haru-circle' ) ,
                'all_items'                     => esc_html__( 'All Team Categories', 'haru-circle' ) ,
                'edit_item'                     => esc_html__( 'Edit Team Category', 'haru-circle' ) ,
                'view_item'                     => esc_html__( 'View Team Category', 'haru-circle' ) ,
                'update_item'                   => esc_html__( 'Update Team Category', 'haru-circle' ) ,
                'add_new_item'                  => esc_html__( 'Add New Team Category', 'haru-circle' ) ,
                'new_item_name'                 => esc_html__( 'New Team Category Name', 'haru-circle' ) ,
                'parent_item'                   => esc_html__( 'Parent Team Category', 'haru-circle' ) ,
                'parent_item_colon'             => esc_html__( 'Parent Team Category:', 'haru-circle' ) ,
                'search_items'                  => esc_html__( 'Search Team Categories', 'haru-circle' ) ,
                'popular_items'                 => esc_html__( 'Popular Team Categories', 'haru-circle' ) ,
                'separate_items_with_commas'    => esc_html__( 'Separate Team Categories with commas', 'haru-circle' ) ,
                'add_or_remove_items'           => esc_html__( 'Add or remove Team Categories', 'haru-circle') ,
                'choose_from_most_used'         => esc_html__( 'Choose from the most used Team Categories', 'haru-circle' ) ,
                'not_found'                     => esc_html__( 'No Team Categories found', 'haru-circle' ) ,
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

            register_taxonomy('team_category', array(
                'haru_teammember'
            ) , $category_args);
        }

        // Add columns to Team Members
        function add_columns($columns) {
            unset(
                $columns['cb'],
                $columns['title'],
                $columns['date']
            );
            $cols = array_merge(array('cb' => ('')), $columns);
            $cols = array_merge($cols, array('title' => esc_html__( 'Name', 'haru-circle' )));
            $cols = array_merge($cols, array('position' => esc_html__( 'Position', 'haru-circle' )));
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
                case 'position': {
                    echo get_post_meta($post_id, "{$prefix}_position", true);
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
            $prefix = $this->prefix;

            $meta_boxes   = array();
            $meta_boxes[] = array(
                'id'            => "{$prefix}_meta_boxes",
                'title'         => esc_html__( 'Team Member Information:', 'haru-circle' ),
                'post_types'    => array( 'haru_teammember' ),
                'fields'        => array(
                    array(
                        'id'    => "{$prefix}_position",
                        'name'  => esc_html__( 'Position', 'haru-circle' ),
                        'type'  => 'text',
                    ),
                    array(
                        'id'   => "{$prefix}_url",
                        'name' => esc_html__( 'Url', 'haru-circle' ),
                        'desc' => esc_html__( 'Please leave empty if use social link.', 'haru-circle' ),
                        'type' => 'url',
                    ),
                    array(
                        'id'             => "{$prefix}_social",
                        'name'           => esc_html__( 'Social', 'haru-circle' ),
                        'desc'           => esc_html__( 'Team Member Social Network Information. Max number of social networks set is 4.', 'haru-circle' ),
                        'type'           => 'social',
                        'network_holder' => esc_html__( 'Title (Ex: Facebook)', 'haru-circle' ),
                        'url_holder'     => esc_html__( 'Url', 'haru-circle' ),
                        'icon_holder'    => esc_html__( 'Icon class (Ex: fa fa-facebook)', 'haru-circle' ),
                        'clone'          => true,
                        'max_clone'      => 4,
                        'sort_clone'     => true,
                        'std'            => '',
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

    new Haru_Teammember_Post_Type;
}